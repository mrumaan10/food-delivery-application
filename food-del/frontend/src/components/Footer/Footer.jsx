import React from 'react'
import './Footer.css'
import { assets } from '../../assets/assets'

const Footer = () => {
  return (
    <div className='footer' id='footer'>
      <div className="footer-content">
        <div className="footer-content-left">
        <h2>PABLOS CATERING</h2>
            <p>Pablos Catering specializes in providing diverse and delicious catering options, emphasizing quality ingredients and professional service for various events and occasions.</p>
            <div className="footer-social-icons">
   
             <a href="https://web.telegram.org" target="_blank" rel="noopener noreferrer">
             <img src={assets.facebook_icon} alt="Facebook" style={{ width: '50px', height: '50px' }} />
             </a>
             <a href={`https://wa.me/${8660612684}`} target="_blank" rel="noopener noreferrer">
             <img src={assets.twitter_icon} alt="Twitter" style={{ width: '50px', height: '50px' }} />
             </a>
             <a href="https://instagram.com" target="_blank" rel="noopener noreferrer">
             <img src={assets.linkedin_icon} alt="LinkedIn" style={{ width: '50px', height: '50px' }} />
             </a>
 
</div>
        </div>
        
        <div className="footer-content-right">
            <h2>GET IN TOUCH</h2>
            <ul>
                <li>+91 8660612684</li>
                <li>+91 7411095213</li>
                <li>+91 8792177813</li>
                <li>pabloscatering@gmail.com</li>
            </ul>
        </div>
      </div>
      <hr />
      <p className="footer-copyright">Copyright 2024 © Pabloscatering.com - All Right Reserved.</p>
    </div>
  )
}

export default Footer
