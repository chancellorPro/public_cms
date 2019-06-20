import getSubFolder from "./getSubFolder";

/**
 * Get file path from storage with sub folders
 *
 * @param {string} rootFolder Root folder in the storage
 * @param {string} fileName   File name
 *
 * @returns {string}
 */
export default function (rootFolder, fileName) {
    return '/storage/' + rootFolder + '/' + getSubFolder(fileName) + '/' + fileName;
}
