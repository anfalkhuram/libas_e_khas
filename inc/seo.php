<?php
// Default SEO Values
$siteName = "Libas-e-Khas";
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$currentDomain = $protocol . "://" . $_SERVER['HTTP_HOST'];
$currentUrl = $currentDomain . parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$seoTitle = isset($pageTitle) && !empty($pageTitle) ? $pageTitle : "$siteName | Elegant Pakistani Clothing & Fashion";
$seoDesc = isset($metaDescription) && !empty($metaDescription) ? $metaDescription : "Discover timeless Pakistani silhouettes crafted for celebrations, traditions, and unforgettable moments.";
$seoCanonical = isset($canonicalUrl) && !empty($canonicalUrl) ? $canonicalUrl : $currentUrl;
$seoOgImage = isset($ogImage) && !empty($ogImage) ? $currentDomain . '/' . ltrim($ogImage, '/') : $currentDomain . "/assets/images/logo.webp";
$seoRobots = isset($robotsMeta) && !empty($robotsMeta) ? $robotsMeta : "index, follow";

// Remove empty query strings if any, unless specific params are needed

// If specific params are needed for canonical (like ?id=123 for product), they should be explicitly set in $canonicalUrl on the page.
?>

<!-- Basic SEO -->
<title><?= htmlspecialchars($seoTitle) ?></title>
<meta name="description" content="<?= htmlspecialchars($seoDesc) ?>">
<meta name="robots" content="<?= htmlspecialchars($seoRobots) ?>">
<link rel="canonical" href="<?= htmlspecialchars($seoCanonical) ?>">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="<?= isset($ogType) ? htmlspecialchars($ogType) : 'website' ?>">
<meta property="og:url" content="<?= htmlspecialchars($seoCanonical) ?>">
<meta property="og:title" content="<?= htmlspecialchars($seoTitle) ?>">
<meta property="og:description" content="<?= htmlspecialchars($seoDesc) ?>">
<meta property="og:image" content="<?= htmlspecialchars($seoOgImage) ?>">
<meta property="og:site_name" content="<?= htmlspecialchars($siteName) ?>">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="<?= htmlspecialchars($seoCanonical) ?>">
<meta name="twitter:title" content="<?= htmlspecialchars($seoTitle) ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($seoDesc) ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($seoOgImage) ?>">

<!-- JSON-LD Structured Data -->
<?php
// Default Organization Schema
$schemaData = isset($schemaData) ? $schemaData : [];
if (empty($schemaData) || !isset($schemaData['@type'])) {
    $schemaData = [
        "@context" => "https://schema.org",
        "@type" => "WebSite",
        "name" => $siteName,
        "url" => $currentDomain,
        "description" => "Premium Pakistani Fashion"
    ];
}

// Convert schema array to JSON-LD if present
if (!empty($schemaData)) {
    // If it's a single schema object, wrap it in a list to allow multiple schemas
    if (!isset($schemaData[0])) {
        $schemas = [$schemaData];
    } else {
        $schemas = $schemaData;
    }
    
    // Always include Organization schema as well
    $orgSchema = [
        "@context" => "https://schema.org",
        "@type" => "Organization",
        "name" => "Libas-e-Khas",
        "url" => $currentDomain,
        "logo" => $currentDomain . "/assets/images/logo.webp"
    ];
    array_push($schemas, $orgSchema);
    
    foreach ($schemas as $schema) {
        echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
}
?>
