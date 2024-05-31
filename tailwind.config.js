/** @type {import('tailwindcss').Config} */
export default {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ],
    theme: {
      extend: {
        boxShadow: {
            "menu" : "0 -10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1)",
            "category" : "0 -6px 15px -3px rgb(0 0 0 / 0.1), 0 6px 6px -4px rgb(0 0 0 / 0.1)",
        }
      },
    },
    plugins: [],
  }
