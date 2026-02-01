<?php
class Transaction {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function deposit($accountId, $amount, $description = '') {
        $this->db->beginTransaction();
        
        try {
            // Create transaction record
            $transactionRef = 'DEP' . date('YmdHis') . mt_rand(1000, 9999);
            
            $sql = "INSERT INTO transactions (transaction_ref, to_account_id, transaction_type, amount, description, status) 
                    VALUES (:ref, :account_id, :type, :amount, :desc, 'completed')";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':ref' => $transactionRef,
                ':account_id' => $accountId,
                ':type' => TRANSACTION_DEPOSIT,
                ':amount' => $amount,
                ':desc' => $description
            ]);
            
            $transactionId = $this->db->lastInsertId();
            
            // Update account balance
            $accountModel = new Account();
            $accountModel->updateBalance($accountId, $amount);
            
            // Create journal entry (credit)
            $this->createJournalEntry($transactionId, $accountId, 'credit', $amount);
            
            $this->db->commit();
            return $transactionId;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
    
    public function transfer($fromAccountId, $toAccountId, $amount, $description = '') {
        $this->db->beginTransaction();
        
        try {
            // Verify sufficient balance
            $accountModel = new Account();
            $balance = $accountModel->getBalance($fromAccountId);
            
            if ($balance < $amount) {
                throw new Exception("Insufficient funds");
            }
            
            // Create transaction record
            $transactionRef = 'TRF' . date('YmdHis') . mt_rand(1000, 9999);
            
            $sql = "INSERT INTO transactions (transaction_ref, from_account_id, to_account_id, transaction_type, amount, description, status) 
                    VALUES (:ref, :from_id, :to_id, :type, :amount, :desc, 'completed')";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':ref' => $transactionRef,
                ':from_id' => $fromAccountId,
                ':to_id' => $toAccountId,
                ':type' => TRANSACTION_TRANSFER,
                ':amount' => $amount,
                ':desc' => $description
            ]);
            
            $transactionId = $this->db->lastInsertId();
            
            // Update balances
            $accountModel->updateBalance($fromAccountId, -$amount);
            $accountModel->updateBalance($toAccountId, $amount);
            
            // Create journal entries
            $this->createJournalEntry($transactionId, $fromAccountId, 'debit', $amount);
            $this->createJournalEntry($transactionId, $toAccountId, 'credit', $amount);
            
            $this->db->commit();
            return $transactionId;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
    
    public function withdrawal($accountId, $amount, $description = '') {
        $this->db->beginTransaction();
        
        try {
            // Verify sufficient balance
            $accountModel = new Account();
            $balance = $accountModel->getBalance($accountId);
            
            if ($balance < $amount) {
                throw new Exception("Insufficient funds");
            }
            
            // Create transaction record
            $transactionRef = 'WD' . date('YmdHis') . mt_rand(1000, 9999);
            
            $sql = "INSERT INTO transactions (transaction_ref, from_account_id, transaction_type, amount, description, status) 
                    VALUES (:ref, :account_id, :type, :amount, :desc, 'completed')";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':ref' => $transactionRef,
                ':account_id' => $accountId,
                ':type' => TRANSACTION_WITHDRAWAL,
                ':amount' => $amount,
                ':desc' => $description
            ]);
            
            $transactionId = $this->db->lastInsertId();
            
            // Update account balance
            $accountModel->updateBalance($accountId, -$amount);
            
            // Create journal entry (debit)
            $this->createJournalEntry($transactionId, $accountId, 'debit', $amount);
            
            $this->db->commit();
            return $transactionId;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
    
    private function createJournalEntry($transactionId, $accountId, $type, $amount) {
        $sql = "INSERT INTO journal_entries (transaction_id, account_id, entry_type, amount) 
                VALUES (:transaction_id, :account_id, :type, :amount)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':transaction_id' => $transactionId,
            ':account_id' => $accountId,
            ':type' => $type,
            ':amount' => $amount
        ]);
    }
    
    public function getHistory($accountId, $limit = 50) {
        $sql = "SELECT t.*, 
                fa.account_number as from_account,
                ta.account_number as to_account
                FROM transactions t
                LEFT JOIN accounts fa ON t.from_account_id = fa.account_id
                LEFT JOIN accounts ta ON t.to_account_id = ta.account_id
                WHERE t.from_account_id = :account_id OR t.to_account_id = :account_id
                ORDER BY t.created_at DESC
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':account_id', $accountId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function updateStatus($transactionId, $status) {
        $sql = "UPDATE transactions SET status = :status WHERE transaction_id = :transaction_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':status' => $status,
            ':transaction_id' => $transactionId
        ]);
    }
    
    public function reverseTransaction($transactionId, $reason = '') {
        $this->db->beginTransaction();
        
        try {
            // Get transaction details
            $sql = "SELECT * FROM transactions WHERE transaction_id = :transaction_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':transaction_id' => $transactionId]);
            $transaction = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$transaction || $transaction['status'] !== 'completed') {
                throw new Exception("Transaction cannot be reversed");
            }
            
            // Reverse the transaction
            $reverseRef = 'REV' . $transaction['transaction_ref'];
            
            $reverseSql = "INSERT INTO transactions (transaction_ref, from_account_id, to_account_id, transaction_type, amount, description, status) 
                           VALUES (:ref, :from_id, :to_id, 'reversal', :amount, :desc, 'completed')";
            
            $reverseStmt = $this->db->prepare($reverseSql);
            $reverseStmt->execute([
                ':ref' => $reverseRef,
                ':from_id' => $transaction['to_account_id'],
                ':to_id' => $transaction['from_account_id'],
                ':amount' => $transaction['amount'],
                ':desc' => 'Reversal of ' . $transaction['transaction_ref'] . ': ' . $reason
            ]);
            
            $reverseId = $this->db->lastInsertId();
            
            // Update balances
            $accountModel = new Account();
            if ($transaction['from_account_id']) {
                $accountModel->updateBalance($transaction['from_account_id'], $transaction['amount']);
            }
            if ($transaction['to_account_id']) {
                $accountModel->updateBalance($transaction['to_account_id'], -$transaction['amount']);
            }
            
            // Mark original as reversed
            $this->updateStatus($transactionId, 'reversed');
            
            // Create reversal journal entries
            if ($transaction['from_account_id']) {
                $this->createJournalEntry($reverseId, $transaction['from_account_id'], 'credit', $transaction['amount']);
            }
            if ($transaction['to_account_id']) {
                $this->createJournalEntry($reverseId, $transaction['to_account_id'], 'debit', $transaction['amount']);
            }
            
            $this->db->commit();
            return $reverseId;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
?>