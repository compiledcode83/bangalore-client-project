import axios from 'axios'

export default {
    getUserCart(id) {
        return axios.get('/cart/' + id)
    },
    postCart(cart) {
        return axios.post('/cart/', cart)
    },
    setCartItem(item) {
        return axios.post('/api/v1/cart/item', item)
    },
    updateCartItemQty(item){
        return axios.post('/api/v1/cart/item/edit', item)
    },
    removeCartItem(item){
        return axios.post('/api/v1/cart/item/remove', item)
    },
    placeOrder(){
        return axios.post('/api/v1/order')
    }
}
