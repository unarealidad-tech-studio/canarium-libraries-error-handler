# canarium-libraries-error-handler

A custom error handler for displaying 404 pages for canarium. This library attaches `ErrorHandler\View\NotFoundStrategy` on bootstrap.

## Template

 To override the 404 page, add this file to your appinstance directory:

view/error/404.phtml

Template Variables | Description
------------------ | -------------
$reason | Contains the reason for the 404
