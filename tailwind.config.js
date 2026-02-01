/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/views/**/*.{html,php}",
    "./public/**/*.php",
    "./app/**/*.php"
  ],
  theme: {
    extend: {
      colors: {
        primary: '#1E3A8A',
        secondary: '#10B981',
        accent: '#F59E0B'
      }
    },
  },
  plugins: [],
}