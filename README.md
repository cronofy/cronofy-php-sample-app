# Cronofy PHP Sample Application

## Prerequisites

### A Git Tool

We would recommend downloading and using the Git Bash tool, which you can find [here](https://git-scm.com/downloads).

### A cloned version of this repository

For help in cloning this repository please see [this](https://help.github.com/articles/cloning-a-repository/) article.

### A local PHP environment

#### Mac

For Mac we would recommend using [MAMP](https://www.mamp.info/en/).

Download and install MAMP, in the Preferences set the Document Root to the repository you have just cloned, click the Start Servers button, and you can visit your site at [http://localhost:8888](http://localhost:8888)

#### Windows

For Windows we would recommend using [XAMPP](https://www.apachefriends.org/index.html).

Download and install XAMPP, then move your cloned repository to `C:/xampp/htdocs/cronofy-php`, open XAMPP and start your servers and then you can visit your site at [http://localhost:80/cronofy-php](http://localhost:80/cronofy-php)

## Set-up

### Create a Cronofy application

To use the Cronofy PHP Sample App you need to create a Cronofy application. To do this, [create a free developer account](https://app.cronofy.com/sign_up/developer), click "Create New App" in the left-hand navigation and create an application.

Once you've created your application you will need to set the `CRONOFY_CLIENT_ID` and `CRONOFY_CLIENT_SECRET` in the application's `globals.php` file.

### Setting up a Remote URL

In order to test [Push Notification](https://www.cronofy.com/developers/api/#push-notifications) callbacks and Enterprise Connect user authentications your application will need to be reachable by the internet.

To do this we would recommend using [ngrok](https://ngrok.com/) to create a URL that is accessible by the Cronofy API.

Once you have ngrok installed you can initialise it for your application by using the following line in your terminal:

`ngrok http -host-header=localhost localhost:8888`
(Replace `localhost:8888` with `localhost:[port number]` where appropriate)

Your terminal will then display a URL in the format `http://[unique identifier].ngrok.io`. You will need to set the `DOMAIN` variable in the application's `globals.php` in order to test these remote features.
