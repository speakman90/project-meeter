import '../styles/app.css';
import 'flowbite/dist/flowbite.min';
import React from 'react';
import * as ReactDOMClient from 'react-dom/client';
import HorizontalNonLinearStepper from './components/MyComponent';

class App extends React.Component {
    render() {
        return (
            <div>
                <HorizontalNonLinearStepper />
            </div>
        );
    }
}

const container = document.getElementById('app');

const root = ReactDOMClient.createRoot(container);

root.render(<App tab="home"/>)


// import '../node_modules/flowbite/dist/datepicker.js';
// start the Stimulus application
// import './bootstrap';