/* ----------------------------------------------------------------------------
 * Copyright (c) 2012 Leibniz Center for Law, University of Amsterdam, the 
 * Netherlands
 *
 * This program and the accompanying materials are licensed and made available
 * under the terms and conditions of the European Union Public Licence (EUPL 
 * v.1.1).
 *
 * You should have received a copy of the  European Union Public Licence (EUPL 
 * v.1.1) along with this program as the file license.txt; if not, please see
 * http://joinup.ec.europa.eu/software/page/eupl/licence-eupl.
 *
 * This software is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.
 * ----------------------------------------------------------------------------
 * Project:      IMPACT
 * Created:      2011-2012
 * Last Change:  14.12.2012 (final release date)
 * ----------------------------------------------------------------------------
 * Created by the Leibniz Center for Law, University of Amsterdam, The 
 * Netherlands, 2012
 * Authors: Jochem Douw (http://jochemdouw.nl), Sander Latour
 * ----------------------------------------------------------------------------
 */
/**
	DEPRECATED
  Sibling of Premise. A Conclusion is a special type of Annotation that belongs to an Argument.
	@param argumentation
	@param name
	@param text
	@param meta - Not used at this time, might be used later for additional information
	@constructor
	@extends Annotation
*/
function Conclusion(argumentation, name, text, meta){
	this.parent = Annotation;
	this.parent(argumentation, name, text, meta);
	this.parent = new Annotation();
	this.setDataItem("conclusion",true);
}
