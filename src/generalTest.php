<?php

function scrapeAmazonProduct($url) {
    $ch = curl_init();
    
  
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
    
    $html = curl_exec($ch);
    
    curl_close($ch);
    
    if (!$html) {
        return null;
    }

    $dom = new DOMDocument();

    @$dom->loadHTML($html);

    $xpath = new DOMXPath($dom);

    $name = '';
    $nameNodes = $xpath->query('//*[@id="productTitle"]');
    if ($nameNodes->length > 0) {
        $name = trim($nameNodes->item(0)->nodeValue);
    } else {
        $nameNodes = $xpath->query('//*[@id="title"]');
        if ($nameNodes->length > 0) {
            $name = trim($nameNodes->item(0)->nodeValue);
        }
    }

    $price = '';
    $priceNodes = $xpath->query('//*[@id="corePriceDisplay_desktop_feature_div"]//span[contains(@class, "a-price-whole")]');
    if ($priceNodes->length > 0) {
        $price = trim($priceNodes->item(0)->nodeValue) . 'AED';
    } else {
        $priceNodes = $xpath->query('//*[@id="priceblock_dealprice"]');
        if ($priceNodes->length > 0) {
            $price = trim($priceNodes->item(0)->nodeValue);
        } else {
            $priceNodes = $xpath->query('//*[@id="priceblock_ourprice"]');
            if ($priceNodes->length > 0) {
                $price = trim($priceNodes->item(0)->nodeValue);
            }
        }
    }

    $description = '';
    $descriptionNodes = $xpath->query('//*[@id="productDescription"]//p | //*[@id="feature-bullets"]//li//span');
    if ($descriptionNodes->length > 0) {
        foreach ($descriptionNodes as $node) {
            $description .= trim($node->nodeValue) . ' ';
        }
    } else {
        $descriptionNodes = $xpath->query('//*[@id="bookDescription_feature_div"]//noscript');
        if ($descriptionNodes->length > 0) {
            foreach ($descriptionNodes as $node) {
                $description .= trim($node->nodeValue) . ' ';
            }
        }
    }
    $description = trim($description);

    $images = [];
    $imageNodes = $xpath->query('//*[@id="altImages"]//img');
    if ($imageNodes->length > 0) {
        foreach ($imageNodes as $node) {
            $images[] = $node->getAttribute('src');
        }
    } else {
        $imageNodes = $xpath->query('//*[@id="imgTagWrapperId"]//img');
        if ($imageNodes->length > 0) {
            $images[] = $imageNodes->item(0)->getAttribute('src');
        }
    }

    return [
        'name' => $name,
        'price' => $price,
        'description' => $description,
        'images' => $images
    ];

}

    // $url = 'https://www.amazon.ae/dp/B07W7CTLD1/ref=sspa_dk_detail_2?psc=1&pd_rd_i=B07W7CTLD1&pd_rd_w=XY46E&content-id=amzn1.sym.0d43935b-1f23-45b4-af79-954185cded88&pf_rd_p=0d43935b-1f23-45b4-af79-954185cded88&pf_rd_r=G8AGP3D7TNG19M80PJHE&pd_rd_wg=QMsI3&pd_rd_r=ca60185d-873c-448c-8119-9f5896552c91&s=beauty&sp_csd=d2lkZ2V0TmFtZT1zcF9kZXRhaWw';

    // $product = scrapeAmazonProduct($url);

    // echo '<pre>';
    // print_r($product);
    // echo '</pre>';
