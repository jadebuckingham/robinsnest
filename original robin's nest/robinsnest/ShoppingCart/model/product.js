// the product class has three properties that will be used by the shopping cart: sku (unique ID), name and price
// product class
function product(sku, name, description, price) {
    this.sku = sku; // product code (SKU = stock keeping unit)
    this.name = name;
    this.description = description;
    this.price = price;
}