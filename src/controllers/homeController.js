const handleGetHomePage = (req, res) => {
    const name = "Duc"
    return res.render("home.ejs", {name})
}

module.exports = {
    handleGetHomePage
}