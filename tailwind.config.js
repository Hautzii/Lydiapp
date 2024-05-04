module.exports = {
  purge: {
    content: [
      './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
      './storage/framework/views/*.php',
      './resources/views/**/*.blade.php',
    ],
    safelist: [],
  },
  theme: {
    extend: {
      colors: {
        'button': '#838cf1'
      },
      textTransform: ['responsive', 'hover', 'focus', 'active', 'group-hover'],
      fontFamily: {
        sans: ['Figtree', 'Arial', 'sans-serif'],
      },
      spacing: {
        'search': '0.625rem',
      },
    },
  },
  plugins: [],
}
