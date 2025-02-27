import express from 'express'

const configViewEngine = (app) => {
    app.use(express.static('./src/public')) // we are telling our app where to access images, css and js files
    app.set("view engine", "ejs")
    app.set("views", "./src/views")
}

export default configViewEngine