<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate Hair | Save Life</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="img/logo.png" type="image/png">
</head>
<body>
    <?php include __DIR__ . '/commen/header.php'; ?>

    <section class="container donate_container">
        <h1>Donate Hair</h1>
        <h3>Find the nearest registered partner salon to donate hair</h3>
        <hr>
    </section>

    <section class="container">
        <div id="map-canvas" class="leaflet-map-box" aria-label="Registered hair donation salons map"></div>
        <div id="map-status"></div>

        <?php
        $salons = [];
        $res = mysqli_query($con, 'SELECT `id`, `s_id`, `name`, `address`, `lat`, `lng`, `contact` FROM `salons` ORDER BY `id` ASC');
        if ($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $salons[] = $row;
            }
        }
        ?>

        <?php if (empty($salons)): ?>
            <div class="empty-state">
                <h3>No Partner Salons Listed Yet</h3>
                <p>Check back soon or contact us to find a hair donation drop-off center near you.</p>
            </div>
        <?php else: ?>
            <div class="details_table">
                <table>
                    <thead>
                        <tr>
                            <th>Salon Name</th>
                            <th>Address</th>
                            <th>Contact</th>
                            <th>Map</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($salons as $idx => $salon): ?>
                            <tr>
                                <td><strong><?php echo e($salon['name']); ?></strong></td>
                                <td><?php echo e($salon['address']); ?></td>
                                <td><?php echo e($salon['contact']); ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline focus-salon-btn" data-index="<?php echo (int)$idx; ?>">
                                        Locate
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>

    <?php include __DIR__ . '/commen/footer.php'; ?>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script>
        (function () {
            var mapEl = document.getElementById("map-canvas");
            var statusEl = document.getElementById("map-status");
            if (!mapEl || typeof L === "undefined") {
                if (statusEl) {
                    statusEl.innerHTML = '<div class="alert alert-warning">Interactive map could not load. Please use the salon directory below.</div>';
                }
                return;
            }

            var map = L.map("map-canvas").setView([6.9271, 79.8612], 11);
            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                maxZoom: 19,
                attribution: "&copy; OpenStreetMap contributors"
            }).addTo(map);

            var markers = [];

            fetch("HelpMapper-backend.php")
                .then(function (r) { return r.json(); })
                .then(function (locations) {
                    if (!Array.isArray(locations) || locations.length === 0) {
                        return;
                    }
                    var bounds = [];
                    locations.forEach(function (loc) {
                        var lat = parseFloat(loc.lat);
                        var lng = parseFloat(loc.lng);
                        if (isNaN(lat) || isNaN(lng)) return;

                        var marker = L.marker([lat, lng]).addTo(map);
                        var popupHtml = "<strong>" + escapeHtml(loc.name) + "</strong><br>" +
                            escapeHtml(loc.address) +
                            (loc.contact ? "<br>Tel: " + escapeHtml(loc.contact) : "");
                        marker.bindPopup(popupHtml);
                        markers.push(marker);
                        bounds.push([lat, lng]);
                    });

                    if (bounds.length > 0) {
                        map.fitBounds(bounds, { padding: [36, 36], maxZoom: 13 });
                    }
                })
                .catch(function () {
                    if (statusEl) {
                        statusEl.innerHTML = '<div class="alert alert-warning">Unable to load salon map markers right now.</div>';
                    }
                });

            document.querySelectorAll(".focus-salon-btn").forEach(function (btn) {
                btn.addEventListener("click", function () {
                    var idx = parseInt(btn.getAttribute("data-index"), 10);
                    var marker = markers[idx];
                    if (marker) {
                        map.setView(marker.getLatLng(), 14, { animate: true });
                        marker.openPopup();
                        mapEl.scrollIntoView({ behavior: "smooth", block: "center" });
                    }
                });
            });

            function escapeHtml(str) {
                return String(str || "").replace(/[&<>"']/g, function (c) {
                    return ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" })[c];
                });
            }
        })();
    </script>
</body>
</html>
