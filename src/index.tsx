import React from 'react';
import { createRoot } from '@wordpress/element';
import PrimaryCategorySelector from "./components/primary-category-selector";

import './index.scss';

const loadSelector = () => {
  const root = document.getElementById('primary-category-selector-root');
  if (root) {
    createRoot(root).render(<PrimaryCategorySelector />);
  }
}

window.addEventListener('load', loadSelector, false);
