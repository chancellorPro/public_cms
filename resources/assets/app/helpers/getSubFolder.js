import md5 from 'blueimp-md5';

/**
 * Get sub folders of the file
 *
 * Result of the function looks like: a1/b2/c3
 * Where md5 of the file = a1b2c3.........
 *
 * @param {string} fileName Name of the file
 *
 * @returns {string}
 */
export default function (fileName) {
    const fileNameHash = md5(fileName).substring(0, 6);
    const pathParts = fileNameHash.match(/.{1,2}/g);
    return pathParts.join('/');
}
