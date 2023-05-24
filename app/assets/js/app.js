import '../styles/app.css';
import 'flowbite/dist/flowbite.min';
import React from 'react';
import { createRoot } from 'react-dom/client';
import { BrowserRouter, Routes, Route } from "react-router-dom";
import HorizontalNonLinearStepper from './components/Stepper';
import Activities from './components/ProfilActivities';

// const container1 = document.getElementById('activities');
// const container2 = document.getElementById('app');

// const root1 = createRoot(container1); // createRoot(container!) if you use TypeScript
// root1.render(<HorizontalNonLinearStepper />);

// const root2 = createRoot(container2);
// root2.render(<Activities />);

// import '../node_modules/flowbite/dist/datepicker.js';
// start the Stimulus application
// import './bootstrap';