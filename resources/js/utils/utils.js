import numeral from 'numeral'

export function goTo(href){
    window.location.href = href;
}

export function formatPrice (n) {
    return numeral(n).format('0,0.00') + ' ₴'
}
