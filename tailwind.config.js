module.exports = {
  content: [
    './*.php',
    './template-parts/**/*.php',
    './inc/**/*.php',
    './src/js/**/*.js',
  ],
  theme: {
    extend: {
      container: {
        center: true,
        padding: '1rem',
        screens: {
          sm: '640px',
          md: '768px',
          lg: '1024px',
          xl: '1280px',
        },
      },
      colors: {
        brand: {
          DEFAULT: '#0F172A',
          accent: '#38BDF8',
        },
      },
    },
  },
  plugins: [],
};
