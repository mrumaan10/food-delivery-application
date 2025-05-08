import React from 'react'
import './Header.css'

const Header = () => {
    return (
        <div className='header'>
            <div className='header-contents'>
                <h2>Make Your Event Deliciously Memorable</h2>
                <p>Welcome to Pablos Catering, where we specialize in creating unforgettable moments through exceptional catering. Discover our diverse menus designed to delight every palate, ensuring your event is a culinary success.</p>
                <button> <a href='#explore-menu' onClick={() => setMenu("menu")}>View Menu</a></button>
            </div>
        </div>
    )
}

export default Header
