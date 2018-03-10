# Simple PHP Base for Apps
The goal of this project is to be a very simple and useful template for quick apps or even bigger ones. It also has Laravel-like routes easy support and uses the actual Codeigniter Query Builder!

## Getting Started
Just download the zip and configure your environment and you are good to go. No need of composer, namespace management, etc.

## Prerequisites
- I've used this base in servers with PHP as low as 5.3 without problems.

## Installing
After downloading and unpacking the zip put the project on your environment.

### Setting up the environment

By default your URLs will look like
```
yourserver.com/
yourserver.com/index.php/your-route
yourserver.com/index.php/your-route/param
```

To solve that you need access to a rewriting url solution. In **.htaccess** it looks like this

```
<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteBase /
  RewriteRule ^(.*)$ index.php?/$1 [L]
</IfModule>
```

Or if your app is not on the root of the environment use

```
<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteBase /path-to/your_app/
  RewriteRule ^(.*)$ index.php?/$1 [L]
</IfModule>
```

Now to configure your **environment.json** file.
Initially it should look like this

```json
{
	"URL_BASE": "http://yourserver.com/index.php",
	"DB_ENV": "development",
	"SHOW_ERRORS": true,
	"VIEW_FOLDER": "views",
	"CONTROLLER_FOLDER": "controllers",
	"MODELS_FOLDER": "models",
	"SYSTEM_FOLDER": "system",
	"CONFIG_FOLDER": "config",
	"USE_ROUTES": true
}
```

All indexes in this json object will be converted to a constant that can be used anywhere in your PHP application.

The **URL_BASE** is the URL that the users will type in to get to your application, make sure it does start with http(s):// and **doesn't** have and ending slash. If you have a rewriting solution setup you can remove the *index.php* part. Also if it is in a subfolder, make sure this points correctly to it.

The **DB_ENV** is the default database for the app to use. Configure this in the **config/db.php** file.

If you want to hide PHP errors simply change **SHOW_ERRORS** to false.

You can also change the default folders names.

The **USE_ROUTES** directive changes the behavior of your app. If you set it to **TRUE** the application will pass all requisitions thru the *Router* class, laravel-like. If you don't like this behavior you can set it to **FALSE** and the system will use a codeigniter-like solution.

### Setting up your databases
Now in the **config/db.php** file you should have at least one environment configured, corresponding to the one you put on your **DB_ENV** directive in your **environment.json** file. You can have multiple database environments set up and you can use any of them at any time.

The **db.php** file should look like this:
```php 
ActiveRecord::addEnv('development', array(
	'driver' => 'mysqli', 
	'host' => 'mysql.server.com', 
	'database' => 'testdb', 
	'username' => 'root', 
	'password' => ''
));
```

### Setting up your routes
If you choose to use codeigniter-like urls, you don't have to setup anything. Just type in your browser
```
yourapp.com/controller-name/method-name/param1/...
```

But if you want custom routes, this offers a nice  laravel-like solution.

You can make your own routes in the **config/routes.php** file. It should look like this

```php
Router::get('/', 'DefaultController', 'index');
```

In the above example you are telling the program that when you access the root of your app thru an HTTP GET request it should call the *index* method of the controller *DefaultController*

It also support Routing Groups, just like laravel.
```php
Router::group('/example', 'DefaultController', array(
	array('get', '/', 'test'),
	array('post', '/test', 'test_all'),
	array('get', '/test/:id', 'test_id'),
));
```

In the above example you just registered three routes:
```
	1. yourapp.com/example
	2. yourapp.com/example/test
	3. yourapp.com/example/test/123
```

In the third example, it has a custom parameter, identified by the **:** at the start, when you navigate to the third url, the router would build something like

```php
$params = array('id' => '123');
DefaultController::test_id($params);
```

## Actually building YOUR application
This base uses the MVC + DAO Standard.

### Views
Put all your public files inside your views folder.
You can have as many subfolders as you like.
If you are using the system Router, it will encapsulate the available files inside the views folder.
So, if you want to include your .js script that is in */views/example/form.js* you should do it like this:
```html
<script src="<?=BASE_URL?>/example/form.js" />
```

Easy and secure.

### Controllers
Now, to actually building your OWN application on top of the base, you create your own controllers with their own methods, and route your urls to it.

Just make sure you load the necessary models using the *Loader* class and you extend the system default controller.

```php
class DefaultController extends Controller {

	...
	Loader::model('DefaultModel');
	...
```

### Models
The models are also pretty straightforward, just extend from the default Model, and include the respective Data-Access-Object.
```php
class DefaultModel extends Model {

	public $id;
	public $description;

	...

	public function __construct()
    {
	Loader::model('DefaultDAO');
	$this->dao = new DefaultDAO();
    }

```

The Data-Access-Objects are also pretty straightforward, just make sure you extend the default system DAO and you will have the beautiful CodeIgniter querybuilder already connected to your database and available for you to use.

[CodeIgniter QueryBuilder Documentation](https://www.codeigniter.com/userguide3/database/query_builder.html)
```php
class DefaultDAO extends DAO {

	public function test() {
		$this->db // <-- THIS IS THE ACTUAL CODE IGNITER ACTIVE RECORD QUERY BUILDER ALREADY CONNECTED TO YOUR DATABASE!
	}
```
