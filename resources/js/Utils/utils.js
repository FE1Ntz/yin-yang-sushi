import numeral from 'numeral'

export function goTo(href){
    window.location.href = href;
}

export function formatPrice (n) {
    return numeral(n).format('0,0.00') + '₴'
}

export function getCartItems() {
    const items = sessionStorage.getItem('cartItems');
    return items ? JSON.parse(items) : [];
}

export function setCartItemQuantity(product, quantity) {
    const items = getCartItems();
    const existingItem = items.find(item => item.id === product.id);

    if (existingItem) {
        if(quantity === 0){
            removeCartItem(product);
            return;
        }

        existingItem.quantity = quantity;
    } else {
        items.push({ id: product.id, quantity: quantity });
    }

    sessionStorage.setItem('cartItems', JSON.stringify(items));
}

export function removeCartItem(product) {
    let items = getCartItems();
    items = items.filter(item => item.id !== product.id);
    sessionStorage.setItem('cartItems', JSON.stringify(items));
}

export function updateCartItem(productId, quantity) {
    const items = getCartItems();
    const item = items.find(item => item.id === productId);

    if (item) {
        item.quantity = quantity;
        sessionStorage.setItem('cartItems', JSON.stringify(items));
    }
}
