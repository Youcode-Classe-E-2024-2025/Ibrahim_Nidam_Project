module.exports = {
  content: [
    "./assets/js/**/*.js",
    "./public/index.php", 
    "src/view/**/*.php", 
    "src/view/sections/**/*.php" 
  ],
  theme: {
    extend: {
      appearance: ['responsive', 'hover', 'focus'],
    },
  },
  plugins: [],
}
