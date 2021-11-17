module.exports = {
  purge: {
    enabled: true,
    content: [
      './app/*.php',
      './app/**/*.php',
      './src/*.html',
      './src/**/*.html',
    ]
  },
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {},
  },
  variants: {
    extend: {

    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
