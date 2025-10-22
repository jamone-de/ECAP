<?php
// ==========================================================
// ECAP / 1.0 Verification Endpoint
// JamOne-DE (joacs.de)
// ----------------------------------------------------------
// Purpose: Provide a machine-verifiable status and checksum
// ==========================================================

header("Content-Type: application/json; charset=utf-8");

// Pfad zum Manifest
$manifestPath = __DIR__ . "/../../manifest.json";


if (!file_exists($manifestPath)) {
    echo json_encode([
        "ecap" => "1.0",
        "verified" => false,
        "error" => "Manifest not found",
        "timestamp" => gmdate("c")
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}


$manifest = json_decode(file_get_contents($manifestPath), true);


if (!isset($manifest["checksum"]) || !isset($manifest["specification"])) {
    echo json_encode([
        "ecap" => "1.0",
        "verified" => false,
        "error" => "Manifest structure invalid",
        "timestamp" => gmdate("c")
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}


$specPath = __DIR__ . "/../ECAP_1_0_Specification.md";
if (!file_exists($specPath)) {
    echo json_encode([
        "ecap" => "1.0",
        "verified" => false,
        "error" => "Specification not found",
        "timestamp" => gmdate("c")
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

$fileHash = strtoupper(hash_file("sha256", $specPath));
$verified = ($fileHash === strtoupper($manifest["checksum"]));


$response = [
    "ecap" => "1.0",
    "verified" => $verified,
    "timestamp" => gmdate("c"),
    "issuer" => $_SERVER["HTTP_HOST"],
    "specification" => $manifest["specification"] ?? null,
    "checksum_manifest" => $manifest["checksum"],
    "checksum_computed" => $fileHash,
    "message" => $verified
        ? "✅ ECAP / 1.0 manifest and specification match. Integrity verified."
        : "❌ Checksum mismatch or invalid manifest.",
];

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
?>
