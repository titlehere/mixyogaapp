module.exports = {
  content: ["./resources/**/*.blade.php", "./resources/**/*.js"],
  theme: {
    extend: {
      colors: {
        primary: "#4A90E2", // Warna utama
        secondary: "#F5A623", // Warna aksen
        background: "#F7F9FC", // Background warna
      },
      fontFamily: {
        sans: ["Roboto", "Arial", "sans-serif"],
        display: ["Poppins", "sans-serif"],
      },
    },
  },
  plugins: [],
};