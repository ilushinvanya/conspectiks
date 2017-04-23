/**
 * Created by Ivan on 22.12.2016.
 */


onmessage = function(e) {
    // e.data is the imageData of the jpeg. {data: U8IntArray, height: int, width: int}
    // you can still convert the jpeg imageData into a blog like this:
    var blob = new Blob( [e.data.data], {type: 'image/jpeg'} );
}