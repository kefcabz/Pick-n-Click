const handleGetHomePage = (req, res) => {
    const name = "Duc"
    return res.render("home.ejs", {name})
}

const handleGetAdminPage = (req, res) => {
    return res.render("admin.ejs")
}

const handleGetCustomerPage = (req, res) => {
    return res.render("customer.ejs")
}

const handleAboutPage = (req, res) => {
    return res.render("about.ejs")
}

const handleDirectRegisterForm = (req, res) => {
    return res.render("register.ejs", {
        errors: null,
        form: {}
    })
}

const handleRegister = async (req, res) => {
    const { email, username, password, confirmPass } = req.body;
    console.log("check: ", email, username, password)
    let errors = {
        isValidEmail: true,
        isValidPhone: true,
        isValidPassword: true,
        isValidConfirmPass: true
    };

    // validating
    if (!email || !/\S+@\S+\.\S+/.test(email)) {
        errors.isValidEmail = false;
    }

    if (!password) {
        errors.isValidPassword = false;
    }

    if (password !== confirmPass) {
        errors.isValidConfirmPass = false;
    }

    const isValid = Object.values(errors).every(v => v === true);

    if (!isValid) {
        return res.render("home.ejs", {
            errors,
            form: { email, username }
        });
    }

    // Call service to save user
    // await registerNewUser(email, phone, username, password);

    return res.redirect("/home.ejs");
};

module.exports = {
    handleGetHomePage, handleGetAdminPage,
    handleGetCustomerPage, handleAboutPage, handleDirectRegisterForm, handleRegister
}