import express from "express"
import { handleGetHomePage, handleAboutPage, handleGetAdminPage, handleGetCustomerPage, handleDirectRegisterForm,
    handleRegister
 } from "../controllers/homeController"

const router = express.Router() //express.Router() is like a mini Express application. It helps organize routes separately instead of defining everything directly in app.js or server.js.
                                //Think of it as a way to manage different routes efficiently.

const initWebRoutes = (app) => {
    //This defines a GET request for the root URL ("/").
    //When a user visits "http://localhost:PORT/", the server responds with "Hello World".
    router.get("/", handleGetHomePage)

    router.get("/about", handleAboutPage)
    router.get("/customer", handleGetCustomerPage)
    router.get("/admin", handleGetAdminPage)
    router.get("/register", handleDirectRegisterForm)
    router.post("/register", handleRegister)

    return app.use("/", router) //This tells Express to use router for handling requests to /.
                                // "/" is the start of any URL used for this website project
}

export default initWebRoutes