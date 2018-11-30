package com.airduino.kevin.airduino;

import android.app.Activity;
import android.app.DownloadManager;
import android.graphics.Color;
import android.net.Uri;
import android.os.Build;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.webkit.DownloadListener;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Toast;

public class MainActivity extends Activity {

    private WebView mWebView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        if(Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP){
            Window window = getWindow();
            window.setStatusBarColor(Color.parseColor("#9e9e9e"));
        }

        // Remove title bar
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        // Set View
        setContentView(R.layout.activity_main);

        // Create an object for webview
        mWebView = findViewById(R.id.airduinoview);
        // Hide the scroll bar
        mWebView.setVerticalScrollBarEnabled(false);

        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.KITKAT) {
            // chromium, enable hardware acceleration
            mWebView.setLayerType(View.LAYER_TYPE_HARDWARE, null);
        } else {
            // older android version, disable hardware acceleration
            mWebView.setLayerType(View.LAYER_TYPE_SOFTWARE, null);
        }

        // Manipulate settings
        WebSettings webSettings = mWebView.getSettings();
        webSettings.setJavaScriptEnabled(true);
        webSettings.setDomStorageEnabled(true);
        webSettings.setSaveFormData(true);
        webSettings.setUserAgentString("airduino-android-app");

        mWebView.setOverScrollMode(View.OVER_SCROLL_NEVER);

        // Stop local links and redirects from, opening in browsser instead of WebView
        mWebView.setWebViewClient(new MyAppWebViewClient());

        // Toast
        mWebView.addJavascriptInterface(new WebAppInterface(this),"Android");

        // Load the page when no internet
        mWebView.setWebViewClient(new WebViewClient(){
            public void onRecievedError(WebView view, int errorCode, String description, String failingUrl){
                mWebView.loadUrl("file:///android_asset/welcome.html");
            }
        });

        mWebView.setDownloadListener(new DownloadListener() {
            @Override
            public void onDownloadStart(String url, String userAgent, String contentDisposition, String mimetype, long contentLength) {
                DownloadManager.Request request = new DownloadManager.Request(Uri.parse(url));
                request.allowScanningByMediaScanner();
                request.setNotificationVisibility(DownloadManager.Request.VISIBILITY_VISIBLE_NOTIFY_COMPLETED);
                DownloadManager dm = (DownloadManager) getSystemService(DOWNLOAD_SERVICE);
                dm.enqueue(request);
                Toast.makeText(getApplicationContext(),"File is being downloaded",Toast.LENGTH_LONG).show();
            }
        });

        mWebView.loadUrl("file:///android_asset/welcome.html");
    }

    @Override
    public void onBackPressed(){
        if(mWebView.canGoBack()){
            mWebView.goBack();
        } else {
            super.onBackPressed();
        }
    }
}
