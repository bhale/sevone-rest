A REST API for SevOne.

This wraps the most used SOAP API methods. 

It is partly an experiment in modernizing some pre-existing PHP code. 

- Follow MVC/DRY patterns as much as possible
- Implement router/front controller pattern with Slim
- Implement CORS middleware
- Separation of concerns between MS SQL database methods and SevOne SOAP API methods
- Uses NotORM for clean OO-style SQL prepared statements 
- Renders Markdown documentation 
- Use Composer for NPM like experience for dependencies
