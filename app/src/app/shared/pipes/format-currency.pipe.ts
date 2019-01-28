import { Pipe, PipeTransform } from '@angular/core';
/*
 * Format Currency VND
 * Usage:
 *   value | formatCurrency
 * Example:
 *   {{ 1060.81 | formatCurrency }}
 *   formats to: 1,060.81 đ
*/
@Pipe({name: 'formatCurrency'})
export class FormatCurrencyPipe implements PipeTransform {
  transform(value: any): string {
    if (value === null) {
      return '';
    }
    // value = value.toFixed(2).toString().replace('.', ',');
    if (typeof value !== 'string') {
      value = value.toString();
    }
    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    value += ' đ';
    return value;
  }
}
