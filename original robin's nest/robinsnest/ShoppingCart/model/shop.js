// the store class has a list of products and provides a getProduct method that retireves an individual product by SKU. this method is used by the storeController to set the current product when the URL routing specifies a productSKU
// SKU = stock keeping unit
function store() {
    this.products = [
        new product ("BAG", "Robin Bag", "A robin themed tote bag.", 5),
        new product ("BRO", "Robin Brooch", "A silver brooch with a robin on it.", 15),
        new product ("EAR", "Robin Earrings", "A pair of earrings with a robin on it.", 10),
        new product ("MUG", "Robin Mug", "A mug with a Robin on it.", 5),
        new product ("NEC", "Robin Necklcae", "A necklace with a robin on it.", 20),
        new product ("SCA", "Robin Scarf", "A scarf with a Robin on it.", 10),
        new product ("SNO", "Robin Snow Globe", "A snow globe with a robin on it.", 25),
        new product ("TOW", "Robin Tea Towel", "A tea towel with a robin on it.", 5),
        new product ("TSH", "Robin Tshirt", "A tshirt with a robin on it.", 15),
        new product ("VAS", "Robin Vase", "A vase with a robin on it.", 30)
    ];
}
store.prototype.getProduct = function (sku) {
    for (var i = 0; i < this.products.length; i++) {
        if (this.products[i].sku == sku)
            return this.products[i];
    }
    return null;
}