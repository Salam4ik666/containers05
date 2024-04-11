<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма ввода</title>
</head>
<body>
    <h1>Добро пожаловать!</h1>
    <p>Пожалуйста, введите ваше имя и возраст.</p>
    
    <form id="welcomeForm">
        <label for="nameInput">Имя:</label>
        <input type="text" id="nameInput" required><br><br>
        
        <label for="ageInput">Возраст:</label>
        <input type="number" id="ageInput" required><br><br>
        
        <button type="button" onclick="submitForm()">Отправить</button>
    </form>

    <p id="welcomeMessage" style="display:none; font-weight:bold;"></p>

    <script>
        function submitForm() {
            var name = document.getElementById("nameInput").value;
            var age = document.getElementById("ageInput").value;

            if (name && age) {
                document.getElementById("welcomeMessage").textContent = `Добро пожаловать, ${name}!`;
                document.getElementById("welcomeMessage").style.display = "block";
            } else {
                alert("Пожалуйста, заполните все поля.");
            }
        }
    </script>
</body>
</html>
