import numeral from 'numeral'

export function goTo(href){
    window.location.href = href;
}

export function formatPrice (n) {
    return numeral(n).format('0,0') + ' ₴'
}

export function formatDate(inputDate) {
    // Створюємо об'єкт Date з вхідної дати
    const date = new Date(inputDate);

    // Отримуємо день, місяць, рік, години та хвилини
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Місяці починаються з 0
    const year = String(date.getFullYear()).slice(2); // Останні дві цифри року
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');

    // Форматуємо дату в потрібний формат
    return `${day}.${month}.${year}, ${hours}:${minutes}`;
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
