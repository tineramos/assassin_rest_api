Register the `CatchAllOptionsRequestsProvider` service provider in `bootstrap/app.php` which will check the incoming request and response successfully if it is an `OPTIONS` request.

Add the `CorsMiddleware` to the `$app->middleware([` array in `bootstrap/app.php` which will attach the following CORS headers to all responses:

* allow all headers
* allow requests from all origins
* allow all the headers which were provided in the request