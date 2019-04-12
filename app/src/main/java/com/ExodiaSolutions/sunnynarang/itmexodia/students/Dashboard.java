package com.ExodiaSolutions.sunnynarang.itmexodia.students;

import android.app.DatePickerDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.graphics.Typeface;
import android.graphics.drawable.Drawable;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Handler;
import android.support.v4.app.FragmentManager;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.MenuItem;
import android.view.ViewGroup;
import android.widget.DatePicker;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.ExodiaSolutions.sunnynarang.itmexodia.DeveloperPage;
import com.ExodiaSolutions.sunnynarang.itmexodia.EditNameDialogFragment;
import com.ExodiaSolutions.sunnynarang.itmexodia.Link;
import com.ExodiaSolutions.sunnynarang.itmexodia.MyAlertDialogFragment;
import com.ExodiaSolutions.sunnynarang.itmexodia.ObjectIO;
import com.ExodiaSolutions.sunnynarang.itmexodia.R;
import com.ExodiaSolutions.sunnynarang.itmexodia.RecyclerItemClickListener;
import com.ExodiaSolutions.sunnynarang.itmexodia.login;
import com.facebook.drawee.backends.pipeline.Fresco;
import com.facebook.drawee.generic.GenericDraweeHierarchy;
import com.facebook.drawee.generic.GenericDraweeHierarchyBuilder;
import com.facebook.drawee.generic.RoundingParams;
import com.facebook.drawee.view.SimpleDraweeView;

import org.apache.commons.io.FileUtils;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLEncoder;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Locale;

import uk.co.chrisjenx.calligraphy.CalligraphyContextWrapper;

public class Dashboard extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener,ObjectIO.ReaderListener{
   private String image;
String section;
    private DatePickerDialog.OnDateSetListener date;
    private String name;
    private int noof = 0;
    private  RecyclerView recyclerView ;
    private NoticeLoader noticeloader;
    private RecyclerCustomAdapter adapter;
    private boolean custom_search;
    private Calendar myCalendar;
    private ProgressDialog pd;
    private ImageView date_btn;
    private String Search_date;
    private ArrayList<Notice_Class> arrayList = new ArrayList<>();
    private String roll,offline_notices="";

    @Override
    protected void attachBaseContext(Context newBase) {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }

    @Override
    protected void onPause() {
        super.onPause();
        custom_search=false;
        if(isNetworkAvailable()&&noticeloader.getStatus()==AsyncTask.Status.RUNNING)
        noticeloader.cancel(true);
    }

   /* @Override
    protected void attachBaseContext(Context newBase) {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }*/
   @Override
   public void ObjectReaderCallback(Object object) {
       if(object!=null){
           Link link1 = (Link) object;
           Link.setInstance(link1);
       }
   }
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Fresco.initialize(Dashboard.this);
        setContentView(R.layout.activity_student_home);

        ObjectIO objectIO = new ObjectIO(this);
        objectIO.readObj();

        date_btn = (ImageView) findViewById(R.id.date_btn);
        myCalendar = Calendar.getInstance();
        /*


            date = new DatePickerDialog.OnDateSetListener() {

                @Override
                public void onDateSet(DatePicker view, int year, int monthOfYear,
                                      int dayOfMonth) {
                    // TODO Auto-generated method stub
                    if (noof % 2 == 0) {
                        myCalendar.set(Calendar.YEAR, year);
                        myCalendar.set(Calendar.MONTH, monthOfYear);
                        myCalendar.set(Calendar.DAY_OF_MONTH, dayOfMonth);
                        String myFormat = "yyyy-MM-dd"; //In which you need put here
                        SimpleDateFormat sdf = new SimpleDateFormat(myFormat, Locale.US);
                        custom_search = true;
                        Search_date = sdf.format(myCalendar.getTime());
                        arrayList.clear();
                        noticeloader.cancel(true);
                        noticeloader = new NoticeLoader(Dashboard.this);
                        noticeloader.execute();
                    }
                    noof++;
                }

            };


        date_btn.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                // TODO Auto-generated method stub
                new DatePickerDialog(Dashboard.this, date, myCalendar
                        .get(Calendar.YEAR), myCalendar.get(Calendar.MONTH),
                        myCalendar.get(Calendar.DAY_OF_MONTH)).show();
            }
        });*/

        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        toolbar.setTitle("Dashboard");
        setSupportActionBar(toolbar);


        custom_search=false;

        name = getIntent().getStringExtra("name");
        image = getIntent().getStringExtra("image");
        section = getIntent().getStringExtra("section");
       // Toast.makeText(this, ""+section, Toast.LENGTH_SHORT).show();
        //class_id= getIntent().getStringExtra("class_id");
        roll=getIntent().getStringExtra("username");
       // batch = getIntent().getStringExtra("batch");
        pd = new ProgressDialog(Dashboard.this);

        recyclerView = (RecyclerView) findViewById(R.id.notice_listview);
        adapter=new RecyclerCustomAdapter(Dashboard.this,arrayList);
        recyclerView.setAdapter(adapter);
        LinearLayoutManager layoutManager = new LinearLayoutManager(this,LinearLayoutManager.VERTICAL,false);
       // GridLayoutManager gridLayoutManager = new GridLayoutManager(this,1);
        recyclerView.setLayoutManager(layoutManager);

        readItems();
        //Toast.makeText(this, offline_subject_list, Toast.LENGTH_SHORT).show();
        if(!offline_notices.equalsIgnoreCase(""))
        {
            try {
                String json=offline_notices;
                JSONArray root= new JSONArray(json);

                for(int i=0;i<root.length();i++)
                {
                    JSONObject jsonObject=root.optJSONObject(i);
                    //  Toast.makeText(Dashboard.this, ""+jsonObject.optString("n_date")+" || "+Search_date, Toast.LENGTH_SHORT).show();

                    if(!custom_search||jsonObject.optString("n_date").equalsIgnoreCase(Search_date)){
                        String title= jsonObject.optString("title");
                        String date=jsonObject.optString("n_date");
                        String teacher=jsonObject.optString("t_name");
                        String body=jsonObject.optString("body");
                        Notice_Class notice=new Notice_Class(title,date,teacher,body);
                        arrayList.add(notice);}
                }
                adapter.notifyDataSetChanged();
            } catch (JSONException e) {
                e.printStackTrace();
            }
        }

            if (isNetworkAvailable()) {
                noticeloader = new NoticeLoader(this);
                noticeloader.execute();
                Handler handler = new Handler();
                handler.postDelayed(new Runnable()
                {
                    @Override
                    public void run() {
                        if ( noticeloader.getStatus() == AsyncTask.Status.RUNNING )

                        {noticeloader.cancel(true);
                            Toast.makeText(Dashboard.this, "Time OUT", Toast.LENGTH_SHORT).show();
                            if(pd.isIndeterminate())
                            pd.dismiss();
                        }
                    }
                }, 20000 );

            } else {if(offline_notices.equalsIgnoreCase(""))
                Toast.makeText(this, "No Internet Connection", Toast.LENGTH_LONG).show();
            }



        recyclerView.addOnItemTouchListener( new RecyclerItemClickListener(Dashboard.this, new RecyclerItemClickListener.OnItemClickListener() {
            @Override public void onItemClick(View view, int position) {
                // TODO Handle item click

                Notice_Class notice_class = arrayList.get(position);
                Intent in = new Intent(Dashboard.this,Notice_Body.class);
                in.putExtra("head",notice_class.getTitle());
                in.putExtra("body",notice_class.getBody());
                in.putExtra("t_name",notice_class.getTeacher());
                showEditDialog(notice_class.getBody(),notice_class.getTeacher(),notice_class.getTitle(),notice_class.getDate());
               // startActivity(in);
            }
        }));

        /*list.setOnItemClickListener(
                new AdapterView.OnItemClickListener() {
                    public void onItemClick(AdapterView<?> parent, View v, int pos, long id) {

                        Notice_Class notice_class = arrayList.get(pos);
                        Intent in = new Intent(Dashboard.this,Notice_Body.class);
                        in.putExtra("head",notice_class.getTitle());
                        in.putExtra("body",notice_class.getBody());
                        in.putExtra("t_name",notice_class.getTeacher());
                        startActivity(in);


                    }
                }


        );*/

        TextView tv = (TextView) findViewById(R.id.dashboard_heading);
        Typeface custom_font1 = Typeface.createFromAsset(getAssets(), "fonts/Lato-Bold.ttf");
        tv.setTypeface(custom_font1);

        NavigationView navigationview = (NavigationView) findViewById(R.id.nav_view);
        navigationview.setNavigationItemSelectedListener(this);
        navigationview.getMenu().getItem(0).setChecked(true);
        View hView =  navigationview.getHeaderView(0);
        TextView nav_user = (TextView)hView.findViewById(R.id.nav_profile_name);
        TextView nav_roll = (TextView)hView.findViewById(R.id.nav_profile_roll);
        nav_roll.setText(roll.toUpperCase());
        //nav_user.setTextColor(this.getResources().getColor(R.color.white));
        Typeface typeface = Typeface.createFromAsset(getAssets(),"fonts/Oswald-Regular.ttf");
        nav_user.setTypeface(typeface);
        nav_user.setText(name);

        Uri imageUri = Uri.parse("http://mis.itmuniversity.ac.in/itmzone/StudentPhoto/"+roll+".jpeg");
        //Toast.makeText(this, "http://mis.itmuniversity.ac.in/itmzone/StudentPhoto/"+roll+".jpeg", Toast.LENGTH_SHORT).show();
        SimpleDraweeView draweeView = (SimpleDraweeView) hView.findViewById(R.id.nav_profile_pic);
        Drawable myIcon = getResources().getDrawable( R.drawable.user_wh );

        GenericDraweeHierarchyBuilder builder =
                new GenericDraweeHierarchyBuilder(getResources());
        GenericDraweeHierarchy hierarchy = builder
                .setFadeDuration(300)
                .setPlaceholderImage(myIcon)
                .build();
        draweeView.setHierarchy(hierarchy);

        RoundingParams roundingParams = RoundingParams.fromCornersRadius(5f);
        roundingParams.setRoundAsCircle(true);
        draweeView.getHierarchy().setRoundingParams(roundingParams);

        draweeView.setImageURI(imageUri);
/*
        FloatingActionButton fab = (FloatingActionButton) findViewById(R.id.fab);
        fab.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                Intent intent = new Intent(Dashboard.this,Chat_list.class);
                intent.putExtra("sender",roll);
                startActivity(intent);
            }
        });*/

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.setDrawerListener(toggle);
        toggle.syncState();


    }

    @Override
    protected void onResume() {
        super.onResume();
        NavigationView navigationview = (NavigationView) findViewById(R.id.nav_view);
        navigationview.setNavigationItemSelectedListener(this);
        navigationview.getMenu().getItem(0).setChecked(true);
    }

    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }
/*
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.student_home, menu);
        return true;
    }*/

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.std_action_settings) {

            Toast.makeText(Dashboard.this, "UnderProcess", Toast.LENGTH_SHORT).show();

            return true;

        }
        if (id == R.id.Std_logout) {
            Intent i = new Intent(Dashboard.this,login.class);
            i.putExtra("remember_not",true);
            Dashboard.this.finish();
            startActivity(i);

            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        int id = item.getItemId();

        if (id == R.id.std_nav_dashboard) {
            readItems();
            custom_search=false;
            if(isNetworkAvailable()){
            noticeloader=new NoticeLoader(this);
            noticeloader.execute();
            }else{if(offline_notices.equalsIgnoreCase(""))
                Toast.makeText(Dashboard.this, "No Internet Connection!", Toast.LENGTH_SHORT).show();
            }
            
            adapter.notifyDataSetChanged();

        }/* else if (id == R.id.std_nav_profile) {
            Intent intent = new Intent(Dashboard.this,NewProfile.class);
            intent.putExtra("image",image);
            intent.putExtra("roll",roll);
            //intent.putExtra("name",name);
           // intent.putExtra("class_id",class_id);
            startActivity(intent);

        }*/else if (id == R.id.std_nav_attendance) {
            Intent intent = new Intent(Dashboard.this,Attendence.class);
            intent.putExtra("roll",roll);
            intent.putExtra("section",section);
            //intent.putExtra("class_id",class_id);
            startActivity(intent);

        }else if (id == R.id.nav_send) {

            showEditDialog2(roll);

        } /* else if (id == R.id.std_nav_subjects) {
            Intent intent = new Intent(Dashboard.this,Subjects.class);
            intent.putExtra("class_id",class_id);
            intent.putExtra("roll",roll);
            startActivity(intent);
        }
        else if (id == R.id.std_nav_classroutines) {

            Intent intent = new Intent(Dashboard.this,Routine_Page.class);
            intent.putExtra("class_id",class_id);
            intent.putExtra("batch",batch);
            startActivity(intent);

        }
        else if (id == R.id.std_nav_classmates) {
            Intent intent = new Intent(Dashboard.this,ClassMates.class);
            intent.putExtra("class_id",class_id);
            intent.putExtra("roll",roll);
            startActivity(intent);

        }*/
        else if (id == R.id.std_nav_exit){
            Dashboard.this.finish();
        }
        else if (id == R.id.nav_signout){
            Intent i = new Intent(Dashboard.this,login.class);
            i.putExtra("remember_not",true);
            Dashboard.this.finish();
            startActivity(i);
        }
        else if (id == R.id.developers){
            Intent i = new Intent(Dashboard.this,DeveloperPage.class);

            startActivity(i);
        }
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }




    public class NoticeLoader extends AsyncTask<Void,Void,String> {

        Context context;
        NoticeLoader(Context context)
        {
            this.context=context;
        }


        @Override
        protected String doInBackground(Void... params) {

            String login_url= null;
            if( Link.getInstance().getHashMapLink().containsKey("get_student_notice")){
                login_url = Link.getInstance().getHashMapLink().get("get_student_notice");
            }

            try{

                URL url =new URL(login_url);
                HttpURLConnection httpurlconnection= (HttpURLConnection) url.openConnection();
                httpurlconnection.setRequestProperty("Accept","text/html");
                httpurlconnection.setRequestMethod("POST");
                httpurlconnection.setDoOutput(true);
                httpurlconnection.setDoInput(true);

                OutputStream outputstream1 = httpurlconnection.getOutputStream();
                BufferedWriter bufferedwriter1 = new BufferedWriter(new OutputStreamWriter(outputstream1, "UTF-8"));

                String post_data1 = URLEncoder.encode("section", "UTF-8") + "=" + URLEncoder.encode(section, "UTF-8");
                bufferedwriter1.write(post_data1);
                bufferedwriter1.flush();
                bufferedwriter1.close();

                InputStream inputstream= httpurlconnection.getInputStream();
                BufferedReader bufferedreader= new BufferedReader(new InputStreamReader(inputstream,"iso-8859-1"));
                String result="";
                String line="";
                while((line = bufferedreader.readLine())!=null){
                    result+=line;
                }
                bufferedreader.close();
                inputstream.close();
                httpurlconnection.disconnect();
                return result;
            }catch(MalformedURLException e){
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }


            return null;

        }


        @Override
        protected void onPreExecute() {
           // Toast.makeText(Dashboard.this, "Yeah", Toast.LENGTH_SHORT).show();
            super.onPreExecute();
            if(offline_notices.equalsIgnoreCase("")||custom_search==true){

            pd.setTitle("Loading.");
            pd.setMessage("Please wait...\nLoading Notices.");
            pd.setCancelable(false);
            pd.show();}
        }

        @Override
        protected void onPostExecute(String result ){
         //   Toast.makeText(context, "DONE", Toast.LENGTH_SHORT).show();
            if(offline_notices.equalsIgnoreCase("")||custom_search==true){
                pd.dismiss();}
            String json=result;
//            Toast.makeText(Class_routine2.this,""+result,Toast.LENGTH_LONG).show();

            if(json!=null){
            try {
               // Toast.makeText(context, ""+result, Toast.LENGTH_SHORT).show();
                arrayList.clear();
                writeItems("");
                writeItems(result);
                JSONArray root= new JSONArray(json);

                for(int i=0;i<root.length();i++)
                {
                    JSONObject jsonObject=root.optJSONObject(i);
                  //  Toast.makeText(Dashboard.this, ""+jsonObject.optString("n_date")+" || "+Search_date, Toast.LENGTH_SHORT).show();

                    if(!custom_search||jsonObject.optString("n_date").equalsIgnoreCase(Search_date)){
                    String title= jsonObject.optString("title");
                    String date=jsonObject.optString("n_date");
                    String teacher=jsonObject.optString("t_name");
                    String body=jsonObject.optString("body");
                    Notice_Class notice=new Notice_Class(title,date,teacher,body);
                    arrayList.add(notice);}
                }
                custom_search = false;
                adapter.notifyDataSetChanged();
            } catch (JSONException e) {

            }}


        }

    }

    private boolean isNetworkAvailable() {
        ConnectivityManager connectivityManager
                = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo activeNetworkInfo = connectivityManager.getActiveNetworkInfo();
        return activeNetworkInfo != null && activeNetworkInfo.isConnected();
    }
    private void writeItems(String s) {
if(custom_search==false){
        File filesDir = getFilesDir();
        File todoFile = new File(filesDir, "notices.txt");
        try {


            FileUtils.writeStringToFile(todoFile ,s);   // TODO: add depenencies for fill utils
        } catch (IOException e) {
            e.printStackTrace();
        }}
    }
    private void readItems()  {
        if(custom_search==false){
        File filesDir = getFilesDir();
        File todoFile = new File(filesDir,"notices.txt");
        try {
            offline_notices = new String(FileUtils.readFileToString(todoFile));
        } catch (IOException e) {
            offline_notices = "";
        }}
    }
    // Create the basic adapter extending from RecyclerView.Adapter
// Note that we specify the custom ViewHolder which gives us access to our views
    public static class RecyclerCustomAdapter extends
            RecyclerView.Adapter<RecyclerCustomAdapter.ViewHolder> {

        Context mContext;
        ArrayList<Notice_Class> mArrayList;

        //constructor
        public RecyclerCustomAdapter(Context context,ArrayList<Notice_Class> marrayList){
            mContext = context;
            mArrayList = marrayList;
        }

        //easy access to context items objects in recyclerView
        private Context getContext() {
            return mContext;
        }

        @Override
        public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
            Context context = parent.getContext();
            LayoutInflater inflater = LayoutInflater.from(context);

            // Inflate the custom layout
            View contactView = inflater.inflate(R.layout.notice_card, parent, false);

            // Return a new holder instance
            ViewHolder viewHolder = new ViewHolder(contactView);
            return viewHolder;

        }

        @Override
        public void onBindViewHolder(ViewHolder viewHolder, int position) {

            // Get the data model based on position
            Notice_Class notice = mArrayList.get(position);

            // Set item views based on your views and data model
            TextView head_tv = viewHolder.head;
            head_tv.setText(notice.getTitle());
           TextView date_tv = viewHolder.date;
            date_tv.setText(notice.getDate());
        }

        @Override
        public int getItemCount() {
            return mArrayList.size();
        }

        // Provide a direct reference to each of the views within a data item
        // Used to cache the views within the item layout for fast access
        public static class ViewHolder extends RecyclerView.ViewHolder {
            // Your holder should contain a member variable
            // for any view that will be set as you render a row
            public TextView head,date;

            // We also create a constructor that accepts the entire item row
            // and does the view lookups to find each subview
            public ViewHolder(View itemView) {
                // Stores the itemView in a public final member variable that can be used
                // to access the context from any ViewHolder instance.
                super(itemView);


                head = (TextView) itemView.findViewById(R.id.notice_head);
                date = (TextView) itemView.findViewById(R.id.notice_time);

            }
        }
    }

    private void showEditDialog(String body,String tec_name,String Title,String date) {
        FragmentManager fm = getSupportFragmentManager();
        EditNameDialogFragment editNameDialogFragment = EditNameDialogFragment.newInstance(Title,body,tec_name,date);
        editNameDialogFragment.show(fm, "notice_fragment_dialog");
    }

    private void showEditDialog2(String Title) {
        FragmentManager fm = getSupportFragmentManager();
        MyAlertDialogFragment editNameDialogFragment = MyAlertDialogFragment.newInstance(Title);
        editNameDialogFragment.show(fm, "password_fd");
    }

}
