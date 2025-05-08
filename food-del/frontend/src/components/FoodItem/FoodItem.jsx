import React, { useContext, useState } from 'react'
import './FoodItem.css'
import { assets } from '../../assets/assets'
import { StoreContext } from '../../Context/StoreContext';
import { useNavigate } from 'react-router-dom';

const FoodItem = ({ image, name, price, desc, id }) => {

    const navigate = useNavigate();
    const [itemCount, setItemCount] = useState(0);
    const { cartItems, addToCart, removeFromCart, url, currency } = useContext(StoreContext);

    const handleClick = () => {
        if(itemCount !== 0)
        {
         console.log(itemCount)
         addToCart(id, itemCount);
         navigate('/cart')
        }
    }


    return (
        <div className='food-item'>
            <div className='food-item-img-container'>
                <img className='food-item-image' src={url + "/images/" + image} alt="" />
                {/* {!cartItems[id]
                ?<img className='add' onClick={() => addToCart(id)} src={assets.add_icon_white} alt="" />
                :<div className="food-item-counter">
                        
                    </div>
                } */}
            </div>
            <div className="food-item-info">
                <div className="food-item-name-rating">
                    <p>{name}</p> <img src={assets.rating_starts} alt="" />
                </div>
                <p className="food-item-desc">{desc}</p>
                <p className="food-item-price">{currency}{price}</p>
                <div className='quantity'>
                    <div>
                        <label for='quantity'>Quantity</label>
                        <input id='quantity' type='number' className='quantity-box' onChange={(e)=> setItemCount(e.target.value)}/>
                    </div>
                    <button className='order-button' onClick={handleClick}>Order</button>
                </div>
            </div>
        </div>
    )
}

export default FoodItem
