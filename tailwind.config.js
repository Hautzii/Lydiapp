// tailwind.config.js
module.exports = {
    purge: {
      content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        // Add any additional paths that contain Tailwind classes
        // or your custom CSS
      ],
      // Safelist any classes that you want to preserve
      // and prevent PurgeCSS from removing
      safelist: [
        // Add any classes that you want to preserve here
      ],
    },
    theme: {
      extend: {
        // Add or extend your theme as needed
        fontFamily: {
          // Customize fonts as needed
          sans: ['Figtree', 'Arial', 'sans-serif'],
        },
      },
    },
    plugins: [
      // Include any plugins you want to use here
    ],
  };
