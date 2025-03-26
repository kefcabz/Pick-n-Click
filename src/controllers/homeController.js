const handleGetHomePage = (req, res) => {
    const name = "Duc"
    return res.render("home.ejs", {name})
}

const handleGetAdminPage = (req, res) => {
    const name = "Duc"
    return res.render("admin.ejs")
}

const handleGetCustomerPage = (req, res) => {
    const name = "Duc"
    return res.render("customer.ejs")
}

const handleAboutPage = (req, res) => {
    const name = "Duc"
    return res.render("about.ejs")
}

module.exports = {
    handleGetHomePage, handleGetAdminPage,
    handleGetCustomerPage, handleAboutPage
}