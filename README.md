A REST API for SevOne.

This wraps the most used SOAP API methods. 

It is partly an experiment in modernizing some pre-existing PHP code. 

- Try to stick to OO/MVC/DRY patterns
- Implement router/front controller pattern with Slim
- Implement CORS middleware
- Separation of concerns between MS SQL database methods and SevOne SOAP API methods
- Uses NotORM for clean OO-style SQL prepared statements 
