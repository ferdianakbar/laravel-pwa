import Dexie from 'dexie';

export const db = new Dexie('PWA_DB');
db.version(1).stores({
    bookmarks: '++id, article_id', // Primary key and indexed props
});
