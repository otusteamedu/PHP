<!DOCTYPE html>
<html>
    <body>

        <h1>Working with RabbitMQ</h1>
        <h2>Form for sending new request:</h2>
        <form action="send_request" method="post">
            Enter your value:<br>
            <input type="text" name="user_input_value">
            <input type="submit" value="submit">
        </form>

        <h2>Form for checking results by Request ID:</h2>
        <form action="check_request" method="post">
            Enter Request ID:<br>
            <input type="text" name="request_id">
            <input type="submit" value="submit">
        </form>

    </body>
</html>