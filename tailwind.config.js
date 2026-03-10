/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        primary: "#012F6B",
        secondary: "#254D81",
        accent: "#F2A65A"
      }
    },
  },
  plugins: [],
}