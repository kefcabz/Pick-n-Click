import express from "express"
import configViewEngine from "./configs/viewEngines"
import initWebRoutes from "./routes/web"

const app = express()

//config view engine
configViewEngine(app)

//init web route
initWebRoutes(app)

const PORT = 8079
app.listen(PORT, () => {
    console.log("Pick n Click backend is running on port ",PORT)
})