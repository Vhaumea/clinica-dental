/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'custom-color': '#123456', 
      },
      spacing: {
        '128': '32rem', 
      },
    },
  },
  plugins: [
    
  ],
}
