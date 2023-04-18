import '../styles/app.css';
import 'flowbite/dist/flowbite.min';
import React from 'react';
import * as ReactDOMClient from 'react-dom/client';
import { BrowserRouter, Routes, Route } from "react-router-dom";
import HorizontalNonLinearStepper from './components/Stepper';

class App extends React.Component {
    render() {
        return (
            <BrowserRouter>
                <Routes>
                    <Route path="/profil" element={<HorizontalNonLinearStepper />} />
                </Routes>
            </BrowserRouter>
        );
    }
}

const container = document.getElementById('app');

const root = ReactDOMClient.createRoot(container);

root.render(<App />)


// import '../node_modules/flowbite/dist/datepicker.js';
// start the Stimulus application
// import './bootstrap';