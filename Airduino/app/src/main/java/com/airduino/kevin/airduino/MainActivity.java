package com.airduino.kevin.airduino;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.view.Window;
import android.webkit.DownloadListener;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;

public class MainActivity extends AppCompatActivity {

    private WebView mWebView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        // Remove title bar
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        // Set View
        setContentView(R.layout.activity_main);

        // Create an object for webview
        mWebView = findViewById(R.id.airduinoview);
        // Hide the scroll bar
        mWebView.setVerticalScrollBarEnabled(false);

        // Manipulate settings
        WebSettings webSettings = mWebView.getSettings();
        webSettings.setJavaScriptEnabled(true);
        webSettings.setDomStorageEnabled(true);
        webSettings.setSaveFormData(true);
        webSettings.setUserAgentString("airduino-android-app");

        mWebView.setOverScrollMode(View.OVER_SCROLL_NEVER);

        // Stop local links and redirects from, opening in browsser instead of WebView
        mWebView.setWebViewClient(new MyAppWebViewClient());

        // Load the page when no internet
        mWebView.setWebViewClient(new WebViewClient(){
            public void onRecievedError(WebView view, int errorCode, String description, String failingUrl){
                mWebView.loadUrl("file:///android_asset/index.html");
            }
        });

        mWebView.loadUrl("file:///android_asset/index.html");
    }
}
