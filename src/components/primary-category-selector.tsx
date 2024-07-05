import React from 'react';
import { __ } from '@wordpress/i18n';
import { useState } from '@wordpress/element';
import { useSelect } from '@wordpress/data'
import { store as coreStore } from '@wordpress/core-data';
import { store as editorStore } from '@wordpress/editor';
import { SelectControl } from '@wordpress/components';
import { Category, CategoryOptions, ThemeVariable } from '../types';

declare var primaryCategorySelector: ThemeVariable;

const PrimaryCategorySelector = () => {
  const initialPrimaryCategory = primaryCategorySelector.primaryCategory;

  const [primaryCategory, setPrimaryCategory] = useState<number>(initialPrimaryCategory);

  const categories = useSelect((select) => {
    const catIds = select(editorStore).getEditedPostAttribute('categories');
    return !!catIds && catIds.length > 0 ?
      select(coreStore).getEntityRecords('taxonomy', 'category', {
        include: catIds.join(','),
        per_page: -1,
        _fields: 'id,name'
      }) : [];

  }, []);

  const options: CategoryOptions[] = [{ label: '— Select Primary Category —', value: '-1' }];
  categories?.forEach((term) => {
    options.push({ label: (term as Category).name, value: `${(term as Category).id}` });
  })

  const handleCategoryChange = (newCategory: string) => setPrimaryCategory(parseInt(newCategory, 10));

  return (
    <SelectControl
      name='primary_category'
      label="Size"
      value={String(primaryCategory)}
      options={options}
      onChange={handleCategoryChange}
      __nextHasNoMarginBottom
    />
  );
};

export default PrimaryCategorySelector;
