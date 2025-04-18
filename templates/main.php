<div class="row">
    <div class="col-lg-8 col-md-10 mx-auto">
        <!-- Intro Card -->
        <div class="card shadow mb-4 border-0 overflow-hidden">
            <div class="card-body p-0">
                <div class="row g-0">
                    <div class="col-md-5 d-flex align-items-center">
                        <div class="p-4 bg-gradient-primary h-100 d-flex flex-column justify-content-center">
                            <h3 class="fw-bold mb-3 text-white">Проверка контрагентов</h3>
                            <p class="mb-0 text-white opacity-80">Введите УНП компании для проверки надежности и получения актуальной информации.</p>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="p-4 p-md-5">
                            <form id="check-form" class="mb-3">
                                <div class="mb-3">
                                    <label for="unp" class="form-label fw-semibold">УНП компании</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-building"></i></span>
                                        <input type="text" class="form-control border-start-0" id="unp" placeholder="Введите УНП (9 цифр)" required pattern="[0-9]{9}">
                                    </div>
                                    <div class="form-text">Пример: 100582333</div>
                                </div>
                                <button class="btn btn-primary btn-lg w-100 rounded-pill shadow-sm" type="submit" id="check-button">
                                    <i class="fas fa-search me-2"></i> Проверить контрагента
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                
        <div id="loading" class="text-center d-none py-5">
            <div class="spinner-grow text-primary" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Загрузка...</span>
            </div>
            <p class="mt-3 text-muted">Идет проверка контрагента, пожалуйста подождите...</p>
        </div>
                
        <div id="error-message" class="alert alert-danger d-none rounded-3 shadow-sm"></div>
                
        <div id="result-container" class="d-none">
            <!-- Карточка с информацией о компании -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-building me-2 text-primary"></i>Информация о компании</h5>
                    <span id="company-status-badge" class="badge"></span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small mb-1">УНП</label>
                                <p class="mb-0 fw-semibold fs-5" id="company-unp"></p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Полное наименование</label>
                                <p class="mb-0 fw-semibold" id="company-name"></p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Краткое наименование</label>
                                <p class="mb-0 fw-semibold" id="company-short-name"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Адрес</label>
                                <p class="mb-0 fw-semibold" id="company-address"></p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Дата регистрации</label>
                                <p class="mb-0 fw-semibold" id="company-registration-date"></p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Инспекция МНС</label>
                                <p class="mb-0 fw-semibold" id="company-tax-office"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                    
            <!-- Рейтинг надежности -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-pie me-2 text-primary"></i>Рейтинг надежности</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-md-5 text-center mb-4 mb-md-0">
                            <div class="rating-circle mb-3">
                                <div class="inner">
                                    <div class="rating-score" id="rating-score">0</div>
                                    <div class="rating-text">из 100</div>
                                </div>
                            </div>
                            <div id="rating-text-description" class="fw-semibold mt-2 fs-5"></div>
                        </div>
                        <div class="col-lg-8 col-md-7">
                            <h5 class="mb-3 fw-semibold">Факторы, влияющие на рейтинг:</h5>
                            <div id="rating-factors" class="mt-4"></div>
                        </div>
                    </div>
                </div>
            </div>
                    
            <!-- Статус источников данных -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-database me-2 text-primary"></i>Источники данных</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="source-status" id="tax-service-status">
                                <h6 class="d-flex align-items-center">
                                    <i class="fas fa-landmark text-primary me-2"></i> МНС Республики Беларусь
                                </h6>
                                <div class="status-indicator">
                                    <i class="fas fa-check-circle text-success"></i>
                                    <span class="status-text">Доступен</span>
                                </div>
                                <button class="btn btn-sm btn-outline-primary mt-3 retry-button rounded-pill" data-source="tax_service">
                                    <i class="fas fa-sync-alt me-1"></i> Обновить
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="source-status" id="liquidation-service-status">
                                <h6 class="d-flex align-items-center">
                                    <i class="fas fa-balance-scale text-primary me-2"></i> JustBel (данные о ликвидации)
                                </h6>
                                <div class="status-indicator">
                                    <i class="fas fa-check-circle text-success"></i>
                                    <span class="status-text">Доступен</span>
                                </div>
                                <button class="btn btn-sm btn-outline-primary mt-3 retry-button rounded-pill" data-source="liquidation_service">
                                    <i class="fas fa-sync-alt me-1"></i> Обновить
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                    
            <!-- Информация о ликвидации -->
            <div class="card mb-4 border-0 shadow-sm" id="liquidation-info-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2 text-primary"></i>Информация о ликвидации</h5>
                </div>
                <div class="card-body">
                    <div id="liquidation-info-container">
                        <p class="text-muted">Информация о ликвидации отсутствует.</p>
                    </div>
                </div>
            </div>
                    
            <!-- Кнопки действий -->
            <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                <button class="btn btn-outline-secondary rounded-pill shadow-sm" id="new-check-button">
                    <i class="fas fa-search me-2"></i> Новая проверка
                </button>
                <div class="auth-only analyst-only administrator-only d-none">
                    <button class="btn btn-success rounded-pill shadow-sm me-2" id="export-pdf-button">
                        <i class="fas fa-file-pdf me-2"></i> Экспорт в PDF
                    </button>
                   ы
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #818cf8, #6366f1);
}
</style>

<script>
$(document).ready(function() {
    // Обработчик формы проверки
    $('#check-form').on('submit', function(e) {
        e.preventDefault();
        
        const unp = $('#unp').val().trim();
        
        // Проверка формата УНП
        if (!/^\d{9}$/.test(unp)) {
            $('#error-message').removeClass('d-none').text('УНП должен состоять из 9 цифр');
            return;
        }
        
        // Скрываем ошибки и результаты предыдущей проверки
        $('#error-message').addClass('d-none');
        $('#result-container').addClass('d-none');
        
        // Показываем индикатор загрузки
        $('#loading').removeClass('d-none');
        
        // Получаем JWT токен, если пользователь авторизован
        const token = getToken();
        const headers = token ? { 'Authorization': 'Bearer ' + token } : {};
        
        // Выполняем запрос к API
        $.ajax({
            url: 'api/check.php',
            type: 'POST',
            contentType: 'application/json',
            headers: headers,
            data: JSON.stringify({ unp: unp }),
            success: function(response) {
                // Скрываем индикатор загрузки
                $('#loading').addClass('d-none');
                
                if (response.status === 'error') {
                    $('#error-message').removeClass('d-none').text('Ошибка при проверке контрагента: оба источника данных недоступны');
                    return;
                }
                
                // Отображаем данные
                displayResults(response.data);
                
               
                $('#result-container').removeClass('d-none');
                
                // Если статус partial, показываем предупреждение
                if (response.status === 'partial') {
                    $('#error-message').removeClass('d-none')
                        .removeClass('alert-danger').addClass('alert-warning')
                        .text('Внимание: некоторые источники данных недоступны. Результаты могут быть неполными.');
                }
            },
            error: function(xhr) {
                // Скрываем индикатор загрузки
                $('#loading').addClass('d-none');
                
                // Показываем ошибку
                let errorMessage = 'Ошибка при проверке контрагента';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                $('#error-message').removeClass('d-none').text(errorMessage);
            }
        });
    });
    
    // Обработчик кнопки "Новая проверка"
    $('#new-check-button').on('click', function() {
        // Очищаем форму
        $('#unp').val('');
        
        // Скрываем результаты и ошибки
        $('#result-container').addClass('d-none');
        $('#error-message').addClass('d-none');
    });
    
   
    $('.retry-button').on('click', function() {
        // Повторяем проверку с текущим УНП
        const unp = $('#unp').val().trim();
        
        if (unp) {
            $('#check-form').submit();
        }
    });
    
  
    $('#export-pdf-button').on('click', function() {
        const user = getCurrentUser();
        
        if (!user || (user.role !== 'administrator' && user.role !== 'analyst')) {
            showMessage('error', 'Для экспорта необходимо войти в систему с правами администратора или аналитика');
            return;
        }
      
        const unp = $('#company-unp').text();
        if (!unp || unp === 'Нет данных') {
            showMessage('error', 'Необходимо сначала выполнить проверку контрагента');
            return;
        }
        
       
        $('#loading').removeClass('d-none');
        
        // Отправляем запрос на экспорт
        $.ajax({
            url: 'api/export_pdf.php',
            type: 'POST',
            contentType: 'application/json',
            headers: { 'Authorization': 'Bearer ' + getToken() },
            data: JSON.stringify({ unp: unp }),
            success: function(response) {
               
                $('#loading').addClass('d-none');
                
                if (response.status === 'success') {
                    // Создаем ссылку для скачивания файла
                    const downloadUrl = response.download_url;
                    
                    // Скачиваем файл
                    const link = document.createElement('a');
                    link.href = downloadUrl;
                    link.download = response.file;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    
                    showMessage('success', 'PDF успешно сформирован и скачан');
                } else {
                    showMessage('error', 'Ошибка при формировании PDF: ' + (response.message || 'неизвестная ошибка'));
                }
            },
            error: function(xhr) {
                // Скрываем индикатор загрузки
                $('#loading').addClass('d-none');
                
                // Показываем ошибку
                let errorMessage = 'Ошибка при формировании PDF';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                showMessage('error', errorMessage);
            }
        });
    });
    
    // Функция для отображения результатов проверки
    function displayResults(data) {
        // Отображение информации о компании
        if (data.company_info) {
            $('#company-unp').text(data.company_info.unp || 'Нет данных');
            $('#company-name').text(data.company_info.name || 'Нет данных');
            $('#company-short-name').text(data.company_info.short_name || 'Нет данных');
            $('#company-address').text(data.company_info.address || 'Нет данных');
            $('#company-registration-date').text(data.company_info.registration_date || 'Нет данных');
            $('#company-tax-office').text(data.company_info.tax_office || 'Нет данных');
            
            // Статус компании
            const statusBadge = $('#company-status-badge');
            statusBadge.text(data.company_info.status || 'Нет данных');
            
            if (data.company_info.status === 'Действующий') {
                statusBadge.removeClass('bg-warning bg-danger').addClass('bg-success');
            } else if (data.company_info.status && data.company_info.status.includes('ликвидации')) {
                statusBadge.removeClass('bg-success bg-danger').addClass('bg-warning');
            } else {
                statusBadge.removeClass('bg-success bg-warning').addClass('bg-danger');
            }
        } else {
            // Если нет информации о компании
            $('#company-unp').text(data.unp || 'Нет данных');
            $('#company-name, #company-short-name, #company-address, #company-registration-date, #company-tax-office').text('Нет данных');
            $('#company-status-badge').text('Нет данных').removeClass('bg-success bg-warning').addClass('bg-danger');
        }
        
        // Отображение рейтинга надежности
        if (data.reliability_rating) {
            const score = data.reliability_rating.score;
            const level = data.reliability_rating.level;
            
            // Устанавливаем значение счетчика
            $('#rating-score').text(score);
            
            // Устанавливаем цвет круга в зависимости от уровня надежности
            const ratingCircle = $('.rating-circle');
            ratingCircle.removeClass('high-reliability medium-reliability low-reliability');
            
            if (level === 'high') {
                ratingCircle.addClass('high-reliability');
            } else if (level === 'medium') {
                ratingCircle.addClass('medium-reliability');
            } else {
                ratingCircle.addClass('low-reliability');
            }
            
            // Проверяем, что рейтинг содержит информацию о счете
            $('.rating-text').text('из 100');
            
            // Отображение факторов
            const factorsContainer = $('#rating-factors');
            factorsContainer.empty();
            
            data.reliability_rating.factors.forEach(function(factor) {
                const factorName = translateFactorName(factor.name);
                const factorScore = factor.score;
                const factorWeight = factor.weight;
                
                // Определяем цвет прогресс-бара в зависимости от оценки фактора
                let barColorClass = 'bg-danger';
                if (factorScore >= 80) {
                    barColorClass = 'bg-success';
                } else if (factorScore >= 50) {
                    barColorClass = 'bg-warning';
                }
                
                // Создаем элемент фактора
                const factorHtml = `
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div class="factor-name">${factorName}</div>
                            <div class="small fw-semibold">${factorScore}/100</div>
                        </div>
                        <div class="factor-bar">
                            <div class="progress">
                                <div class="progress-bar ${barColorClass}" role="progressbar" 
                                    style="width: ${factorScore}%" aria-valuenow="${factorScore}" 
                                    aria-valuemin="0" aria-valuemax="100">
                                    <span class="factor-weight">${factorWeight}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                factorsContainer.append(factorHtml);
            });
            
            // Добавляем текстовое описание рейтинга
            let ratingText = '';
            if (score >= 80) {
                ratingText = 'Надежный контрагент';
            } else if (score >= 50) {
                ratingText = 'Средняя надежность';
            } else {
                ratingText = 'Низкая надежность';
            }
            
            $('#rating-text-description').text(ratingText);
            
        } else {
            // Если нет данных о рейтинге
            $('#rating-score').text('N/A');
            $('.rating-text').text('из 100');
            $('.rating-circle').removeClass('high-reliability medium-reliability low-reliability');
            $('#rating-factors').html('<p class="text-muted">Невозможно рассчитать рейтинг надежности из-за отсутствия данных.</p>');
            $('#rating-text-description').text('');
        }
        
        // Отображение статуса источников данных
        updateSourceStatus('tax_service', data.sources_status.tax_service);
        updateSourceStatus('liquidation_service', data.sources_status.liquidation_service);
        
        // Отображение информации о ликвидации
        if (data.liquidation_info && data.liquidation_info.length > 0) {
            const liquidationContainer = $('#liquidation-info-container');
            liquidationContainer.empty();
            
            // Создаем таблицу с информацией о ликвидации
            const tableHtml = `
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Дата решения</th>
                                <th>Дата ликвидации</th>
                                <th>Статус</th>
                                <th>Ликвидатор</th>
                            </tr>
                        </thead>
                        <tbody id="liquidation-table-body">
                        </tbody>
                    </table>
                </div>
            `;
            
            liquidationContainer.append(tableHtml);
            
            const tableBody = $('#liquidation-table-body');
            
            data.liquidation_info.forEach(function(item) {
                const row = `
                    <tr>
                        <td>${formatDate(item.liquidationDecisionDate) || 'Нет данных'}</td>
                        <td>${formatDate(item.liquidationDate) || 'Нет данных'}</td>
                        <td>${getEntityStateText(item.entityState) || 'Нет данных'}</td>
                        <td>${item.liquidatorName || 'Нет данных'}</td>
                    </tr>
                `;
                
                tableBody.append(row);
            });
            
       
            $('#liquidation-info-card').removeClass('d-none');
        } else {
        
            $('#liquidation-info-container').html('<p class="text-muted">Информация о ликвидации отсутствует.</p>');
            
           
            $('#liquidation-info-card').removeClass('d-none');
        }
    }
    
    // Функция для обновления статуса источника данных
    function updateSourceStatus(source, status) {
        const statusElement = source === 'tax_service' ? $('#tax-service-status') : $('#liquidation-service-status');
        const statusIndicator = statusElement.find('.status-indicator');
        const statusIcon = statusIndicator.find('i');
        const statusText = statusIndicator.find('.status-text');
        
        if (status.available) {
            statusIcon.removeClass('fa-times-circle text-danger').addClass('fa-check-circle text-success');
            statusText.text('Доступен');
        } else {
            statusIcon.removeClass('fa-check-circle text-success').addClass('fa-times-circle text-danger');
            statusText.text('Недоступен: ' + (status.error || 'Неизвестная ошибка'));
        }
    }
    
    // Функция для форматирования даты
    function formatDate(dateString) {
        if (!dateString) return null;
        
        const date = new Date(dateString);
        
        if (isNaN(date.getTime())) {
            return dateString;
        }
        
        return date.toLocaleDateString('ru-RU');
    }
    
    // Функция для получения текстового представления статуса организации
    function getEntityStateText(state) {
        const states = {
            1: 'В процессе ликвидации',
            2: 'Ликвидирован',
            0: 'Действующий'
        };
        
        return states[state] || `Неизвестный статус (${state})`;
    }
    
    // Функция для перевода названий факторов
    function translateFactorName(factor) {
        const translations = {
            company_status: 'Статус юридического лица',
            company_age: 'Время существования компании',
            liquidation: 'Наличие процессов ликвидации',
            tax_registration: 'Регистрация в налоговой'
        };
        
        return translations[factor] || factor;
    }
});
</script> 