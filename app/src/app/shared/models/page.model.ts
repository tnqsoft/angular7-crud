export class Page {
  // The number of elements in the page
  public size = 0;
  // The total number of elements
  public totalElements = 0;
  // The total number of pages
  public totalPages = 0;
  // The current page number
  public pageNumber = 0;

  constructor() {
    this.pageNumber = 1;
    this.size = 10;
  }
}

// export interface IPage {
//   // pageCount: number;
//   // pageNo: number;
//   // pageSize: number;
//   // recordStart: number;
//   // recordEnd: number;
//   // recordCount: number;
//   count: number;
//   pageSize: number;
//   limit: number;
//   offset: number;
// }

// export class Page implements IPage {
//   // public pageCount: number;
//   // public pageNo: number;
//   // public pageSize: number;
//   // public recordCount: number;
//   // public recordStart: number;
//   // public recordEnd: number;
//   public count: number;
//   public pageSize: number;
//   public limit: number;
//   public offset: number;

//   constructor() {
//     this.offset = 1;
//     this.pageSize = 10;
//   }
// }
