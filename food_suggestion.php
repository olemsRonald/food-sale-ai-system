<?php
function suggestFood($health) {
    $health = strtolower($health);

    if (str_contains($health, 'diabetes')) {
        return "Grilled fish, steamed vegetables, brown rice";
    } elseif (str_contains($health, 'hypertension') || str_contains($health, 'high blood pressure')) {
        return "Low-sodium soup, boiled plantain, avocado";
    } elseif (str_contains($health, 'underweight')) {
        return "Peanut soup, yam porridge, banana smoothie";
    } elseif (str_contains($health, 'overweight') || str_contains($health, 'obesity')) {
        return "Vegetable salad, fruit bowl, lean chicken";
    } elseif (str_contains($health, 'pregnant')) {
        return "Ndolé with meat, beans and pap, fruits";
    } else {
        return "Eru, Achu, Koki, rice and beans, grilled fish";
    }
}
?>