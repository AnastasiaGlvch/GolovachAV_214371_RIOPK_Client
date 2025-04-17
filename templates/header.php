<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Проверка контрагентов</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="header-content">
            <a href="index.php" class="header-brand">
                <div class="brand-logo">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <span>Проверка контрагентов</span>
                <span class="brand-tagline"></span>
            </a>
            <div class="header-actions">
                <div id="auth-buttons">
                    <button class="btn btn-primary btn-rounded" id="login-button" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="fas fa-user me-2"></i>Вход
                    </button>
                </div>
                <div id="user-info" class="d-none">
                    <div class="user-menu">
                        <div class="user-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <span class="user-name" id="username-display"></span>
                            <span class="user-role" id="role-badge"></span>
                        </div>
                        <button class="btn btn-icon btn-sm" id="logout-button">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">
                            <i class="fas fa-home"></i>
                            <span>Главная</span>
                        </a>
                    </li>
                    <li class="nav-item auth-only analyst-only administrator-only d-none">
                        <a class="nav-link" href="reports.php">
                            <i class="fas fa-history"></i>
                            <span>История проверок</span>
                        </a>
                    </li>
                    <li class="nav-item auth-only administrator-only d-none">
                        <a class="nav-link" href="admin.php">
                            <i class="fas fa-users-cog"></i>
                            <span>Управление пользователями</span>
                        </a>
                    </li>
                    <li class="nav-item auth-only administrator-only d-none">
                        <a class="nav-link" href="settings.php">
                            <i class="fas fa-cog"></i>
                            <span>Настройки</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Модальное окно для входа -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Вход в систему</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="login-error"></div>
                    <form id="login-form">
                        <div class="mb-3">
                            <label for="username" class="form-label">Имя пользователя</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="username" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-rounded w-100">Войти</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="main-content">
        <div class="container">
            <div id="system-message" class="alert d-none"></div>
    
    <script>
        // Работа с JWT и авторизацией
        $(document).ready(function() {
            // Проверка наличия токена в localStorage
            checkAuthStatus();
            
            // Обработчик формы входа
            $('#login-form').on('submit', function(e) {
                e.preventDefault();
                
                const username = $('#username').val();
                const password = $('#password').val();
                
                $.ajax({
                    url: 'services/auth/api/login.php',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        username: username,
                        password: password
                    }),
                    success: function(response) {
                        if (response.status === 'success') {
                            // Сохраняем токен и данные пользователя
                            localStorage.setItem('jwt_token', response.data.token);
                            localStorage.setItem('user', JSON.stringify(response.data.user));
                            
                            // Закрываем модальное окно
                            $('#loginModal').modal('hide');
                            
                            // Обновляем интерфейс
                            updateUI(response.data.user);
                            
                            // Показываем сообщение об успешном входе
                            showMessage('success', 'Вы успешно вошли в систему.');
                        } else {
                            // Показываем ошибку
                            $('#login-error').removeClass('d-none').text(response.message);
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Ошибка при входе';
                        
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        $('#login-error').removeClass('d-none').text(errorMessage);
                    }
                });
            });
            
            // Обработчик выхода
            $('#logout-button').on('click', function() {
                // Удаляем токен и данные пользователя
                localStorage.removeItem('jwt_token');
                localStorage.removeItem('user');
                
                // Обновляем интерфейс
                updateUI(null);
                
                // Показываем сообщение о выходе
                showMessage('info', 'Вы вышли из системы.');
            });
            
            // Функция для проверки статуса авторизации
            function checkAuthStatus() {
                const token = localStorage.getItem('jwt_token');
                
                if (token) {
                    // Проверяем валидность токена
                    $.ajax({
                        url: 'services/auth/api/validate-token.php',
                        type: 'POST',
                        headers: {
                            'Authorization': 'Bearer ' + token
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                // Обновляем данные пользователя
                                localStorage.setItem('user', JSON.stringify(response.data.user));
                                
                                // Обновляем интерфейс
                                updateUI(response.data.user);
                            } else {
                                // Токен недействителен, удаляем его
                                localStorage.removeItem('jwt_token');
                                localStorage.removeItem('user');
                                updateUI(null);
                            }
                        },
                        error: function() {
                            // При ошибке удаляем токен
                            localStorage.removeItem('jwt_token');
                            localStorage.removeItem('user');
                            updateUI(null);
                        }
                    });
                } else {
                    // Токена нет, отображаем интерфейс для неавторизованного пользователя
                    updateUI(null);
                }
            }
            
            // Функция для обновления интерфейса в зависимости от статуса авторизации
            function updateUI(user) {
                if (user) {
                    // Пользователь авторизован
                    $('#auth-buttons').addClass('d-none');
                    $('#user-info').removeClass('d-none');
                    $('#username-display').text(user.username);
                    
                    // Настраиваем отображение роли
                    const roleBadge = $('#role-badge');
                    roleBadge.text(translateRole(user.role));
                    
                    // Показываем элементы в зависимости от роли
                    $('.auth-only').removeClass('d-none');
                    
                    if (user.role === 'administrator') {
                        $('.administrator-only').removeClass('d-none');
                    } else {
                        $('.administrator-only').addClass('d-none');
                    }
                    
                    if (user.role === 'analyst' || user.role === 'administrator') {
                        $('.analyst-only').removeClass('d-none');
                    } else {
                        $('.analyst-only').addClass('d-none');
                    }
                } else {
                    // Пользователь не авторизован
                    $('#auth-buttons').removeClass('d-none');
                    $('#user-info').addClass('d-none');
                    $('.auth-only').addClass('d-none');
                }
            }
            
            // Функция для отображения системных сообщений
            function showMessage(type, message) {
                const messageElement = $('#system-message');
                messageElement.removeClass('d-none alert-success alert-danger alert-info alert-warning');
                
                if (type === 'success') {
                    messageElement.addClass('alert-success');
                } else if (type === 'error') {
                    messageElement.addClass('alert-danger');
                } else if (type === 'warning') {
                    messageElement.addClass('alert-warning');
                } else {
                    messageElement.addClass('alert-info');
                }
                
                messageElement.text(message);
                
                // Автоматическое скрытие сообщения через 5 секунд
                setTimeout(function() {
                    messageElement.addClass('d-none');
                }, 5000);
            }
            
            // Функция для перевода названия роли
            function translateRole(role) {
                const translations = {
                    administrator: 'Администратор',
                    analyst: 'Аналитик',
                    guest: 'Гость'
                };
                
                return translations[role] || role;
            }
        });
        
        // Функция для получения текущего пользователя
        function getCurrentUser() {
            // Проверяем кеш сессии
            if (window.sessionUserCache) {
                return window.sessionUserCache;
            }
            
            const userJson = localStorage.getItem('user');
            if (!userJson) {
                return null;
            }
            
            try {
                const user = JSON.parse(userJson);
                // Кешируем пользователя в рамках текущей сессии
                window.sessionUserCache = user;
                return user;
            } catch (e) {
                console.error("Ошибка при парсинге данных пользователя:", e);
                return null;
            }
        }
        
        // Функция для получения токена с локальной проверкой валидности
        function getToken() {
            // Проверяем кеш сессии
            if (window.sessionTokenCache) {
                return window.sessionTokenCache;
            }
            
            const token = localStorage.getItem('jwt_token');
            
            if (!token) {
                return null;
            }
            
            // Локальная проверка токена на истечение срока
            try {
                // Извлекаем payload из токена
                const parts = token.split('.');
                if (parts.length !== 3) {
                    console.error("Некорректный формат токена");
                    localStorage.removeItem('jwt_token');
                    localStorage.removeItem('user');
                    window.sessionUserCache = null;
                    return null;
                }
                
                // Декодируем payload
                const payload = JSON.parse(atob(parts[1].replace(/-/g, '+').replace(/_/g, '/')));
                
                // Проверяем срок действия токена
                if (payload.exp && payload.exp < Math.floor(Date.now() / 1000)) {
                    console.error("Токен просрочен");
                    localStorage.removeItem('jwt_token');
                    localStorage.removeItem('user');
                    window.sessionUserCache = null;
                    return null;
                }
                
                // Кешируем токен в рамках сессии
                window.sessionTokenCache = token;
                return token;
            } catch (e) {
                console.error("Ошибка при проверке токена:", e);
                return token; // В случае ошибки возвращаем токен как есть, сервер выполнит валидацию
            }
        }
    </script>
</body>
</html> 