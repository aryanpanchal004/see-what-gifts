<!DOCTYPE html>
<html>

<head>
    <title>Welcome to My Site</title>
    <style>
        * {
            text-align: center
        }

        h1 {
            font-weight: bold;
            color: red;
            font-size: 40px;
            text-align: center;
        }

        p {
            font-size: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>N.M Gift Store</h1>
    <p>This person is trying to contact you through site.</p>
    <p>Name : {{ $contact->name }}</p>
    <p>Message: {{ $contact->message }}</p>
    <p>Mail: {{ $contact->email }}</p>
</body>

</html>
