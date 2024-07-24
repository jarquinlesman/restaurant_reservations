<?php
require_once '../routes/restaurant_route.php'; // Incluye la ruta que a su vez incluye el controlador

$restaurantsData = getRestaurants(); // Llama a la función del controlador
$restaurants = $restaurantsData['restaurants'];
$error = $restaurantsData['error'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuestros Restaurantes</title>
    <link rel="stylesheet" href="../css/style-restaurant.css">
    <script>
        function showError(error) {
            if (error) {
                alert(error);
            }
        }
    </script>
</head>
<body onload="showError('<?php echo htmlspecialchars($error); ?>')">
    <div class="container">
        <h1>Nuestros Restaurantes</h1>
        <div class="restaurant-list">
            <?php if (empty($restaurants)): ?>
                <p>No se encontraron restaurantes disponibles.</p>
            <?php else: ?>
                <?php foreach ($restaurants as $restaurant): ?>
                    <div class="restaurant-card">
                        <img src="data:image/jpeg;base64,<?php echo htmlspecialchars($restaurant['Image']); ?>" alt="Restaurante">
                        <div class="restaurant-info">
                            <h2><?php echo htmlspecialchars($restaurant['Name']); ?></h2>
                            <p>Dirección: <?php echo htmlspecialchars($restaurant['Location']); ?></p>
                            <p>Teléfono: <?php echo htmlspecialchars($restaurant['Phone']); ?></p>
                            <p>Email: <?php echo htmlspecialchars($restaurant['Email']); ?></p>
                            <form action="reservar.php" method="GET">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($restaurant['Id_Rest']); ?>">
                                <input type="hidden" name="name" value="<?php echo htmlspecialchars($restaurant['Name']); ?>">
                                <input type="hidden" name="location" value="<?php echo htmlspecialchars($restaurant['Location']); ?>">
                                <input type="hidden" name="phone" value="<?php echo htmlspecialchars($restaurant['Phone']); ?>">
                                <input type="hidden" name="email" value="<?php echo htmlspecialchars($restaurant['Email']); ?>">
                                <input type="hidden" name="image" value="data:image/jpeg;base64,<?php echo htmlspecialchars($restaurant['Image']); ?>">
                                <button type="submit">Reservar</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>