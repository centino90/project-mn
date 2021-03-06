module.exports = {
  plugins: [
    require("postcss-import"),
    require("tailwindcss"),
    require("autoprefixer"),
    require('postcss-csso')({
      restructure: false
    })
  ],
};
