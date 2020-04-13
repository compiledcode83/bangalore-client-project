import axios from 'axios'

export default {
    getUserCart(id) {
        return axios.get('api/v1/cart/restore',{
            headers: {
                "Authorization": `Bearer ${this.$store.state.authModule.accessToken}`
            }
        })
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
    placeOrder(data){
        return axios.post('/api/v1/order', data)
    }
}
