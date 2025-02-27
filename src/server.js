import express from "express"
import configViewEngine from "./configs/viewEngines"
import initWebRoutes from "./routes/web"
require("dotenv").config()

const app = express()
const PORT = process.env.PORT ||8079

//config view engine
configViewEngine(app)

//init web route
initWebRoutes(app)

app.listen(PORT, () => {
    console.log("Pick n Click backend is running on port ",PORT)
})