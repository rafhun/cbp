/**
 * Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

// This file contains style definitions that can be used by CKEditor plugins.
//
// The most common use for it is the "stylescombo" plugin, which shows a combo
// in the editor toolbar, containing all styles. Other plugins instead, like
// the div plugin, use a subset of the styles on their feature.
//
// If you don't have plugins that depend on this file, you can simply ignore it.
// Otherwise it is strongly recommended to customize this file to match your
// website requirements and design properly.

CKEDITOR.stylesSet.add( 'default', [
  /* Block Styles */

  // Below are some examples for the use of the styles dropdown
  // uncomment what you need
  
  // { name: 'Link Liste',   element: 'ul', attributes: { 'class': 'link-list' } },
  { name: 'Link',     element: 'a', attributes: { 'class': 'icon-link link-icon' } },
  { name: 'Mail Link',      element: 'a', attributes: { 'class': 'icon-mail link-icon' } },
  { name: 'Film Link',      element: 'a', attributes: { 'class': 'icon-movie link-icon' } },
  { name: 'PDF Link',      element: 'a', attributes: { 'class': 'icon-pdf link-icon' } },
  { name: 'Phone Link',      element: 'a', attributes: { 'class': 'icon-phone link-icon' } },
] );

