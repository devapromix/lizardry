object FrameTown: TFrameTown
  Left = 0
  Top = 0
  Width = 897
  Height = 474
  Font.Charset = RUSSIAN_CHARSET
  Font.Color = clWindowText
  Font.Height = -19
  Font.Name = 'Courier New'
  Font.Style = []
  ParentFont = False
  TabOrder = 0
  object RightPanel: TPanel
    Left = 617
    Top = 0
    Width = 280
    Height = 474
    Align = alRight
    BevelOuter = bvNone
    ParentBackground = False
    TabOrder = 0
    object Panel8: TPanel
      Tag = 1
      Left = 0
      Top = 0
      Width = 280
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = 'CharName'
      ParentBackground = False
      TabOrder = 0
      object bbLogout: TSpeedButton
        Left = 192
        Top = 1
        Width = 87
        Height = 23
        Cursor = crHandPoint
        Align = alRight
        Caption = #1042#1099#1093#1086#1076
        Flat = True
        OnClick = bbLogoutClick
      end
    end
    object Panel12: TPanel
      Tag = 5
      Left = 0
      Top = 250
      Width = 280
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = #1047#1086#1083#1086#1090#1086' 0'
      ParentBackground = False
      TabOrder = 1
    end
    object Panel13: TPanel
      Tag = 5
      Left = 0
      Top = 50
      Width = 280
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = #1054#1087#1099#1090': 0/100'
      ParentBackground = False
      TabOrder = 2
    end
    object Panel14: TPanel
      Tag = 5
      Left = 0
      Top = 75
      Width = 280
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = #1047#1076#1086#1088#1086#1074#1100#1077': 30/30'
      ParentBackground = False
      TabOrder = 3
    end
    object Panel15: TPanel
      Tag = 5
      Left = 0
      Top = 225
      Width = 280
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = #1055#1088#1086#1074#1080#1079#1080#1103' 7/7'
      ParentBackground = False
      TabOrder = 4
    end
    object Panel16: TPanel
      Tag = 5
      Left = 0
      Top = 100
      Width = 280
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = #1052#1072#1085#1072': 20/20'
      ParentBackground = False
      TabOrder = 5
    end
    object Panel11: TPanel
      Tag = 4
      Left = 0
      Top = 25
      Width = 280
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = #1059#1088#1086#1074#1077#1085#1100': 1'
      ParentBackground = False
      TabOrder = 6
      object bbDebug: TSpeedButton
        Left = 192
        Top = 1
        Width = 87
        Height = 23
        Align = alRight
        Caption = 'Debug'
        Flat = True
        OnClick = bbDebugClick
      end
    end
    object Panel17: TPanel
      Tag = 5
      Left = 0
      Top = 150
      Width = 280
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = #1059#1088#1086#1085': 2-3'
      ParentBackground = False
      TabOrder = 7
      ExplicitLeft = 4
      ExplicitTop = 147
    end
    object Panel18: TPanel
      Tag = 5
      Left = 0
      Top = 200
      Width = 280
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = #1041#1088#1086#1085#1103': 0'
      ParentBackground = False
      TabOrder = 8
    end
    object pnEqWeapon: TPanel
      Tag = 5
      Left = 0
      Top = 125
      Width = 280
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = #1054#1088#1091#1078#1080#1077':'
      ParentBackground = False
      TabOrder = 9
    end
    object pnEqArmor: TPanel
      Tag = 5
      Left = 0
      Top = 175
      Width = 280
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = #1041#1088#1086#1085#1103':'
      ParentBackground = False
      TabOrder = 10
      ExplicitTop = 150
    end
  end
  object LeftPanel: TPanel
    Left = 0
    Top = 0
    Width = 280
    Height = 474
    Align = alLeft
    BevelOuter = bvNone
    ParentBackground = False
    TabOrder = 1
    object LinkPanel1: TPanel
      Tag = 1
      Left = 0
      Top = 0
      Width = 280
      Height = 25
      Cursor = crHandPoint
      Align = alTop
      Alignment = taLeftJustify
      ParentBackground = False
      TabOrder = 0
      Visible = False
      OnClick = LeftPanelClick
    end
    object LinkPanel2: TPanel
      Tag = 2
      Left = 0
      Top = 25
      Width = 280
      Height = 25
      Cursor = crHandPoint
      Align = alTop
      Alignment = taLeftJustify
      ParentBackground = False
      TabOrder = 1
      Visible = False
      OnClick = LeftPanelClick
    end
    object LinkPanel3: TPanel
      Tag = 3
      Left = 0
      Top = 50
      Width = 280
      Height = 25
      Cursor = crHandPoint
      Align = alTop
      Alignment = taLeftJustify
      ParentBackground = False
      TabOrder = 2
      Visible = False
      OnClick = LeftPanelClick
    end
    object LinkPanel4: TPanel
      Tag = 4
      Left = 0
      Top = 75
      Width = 280
      Height = 25
      Cursor = crHandPoint
      Align = alTop
      Alignment = taLeftJustify
      ParentBackground = False
      TabOrder = 3
      Visible = False
      OnClick = LeftPanelClick
    end
    object LinkPanel5: TPanel
      Tag = 5
      Left = 0
      Top = 100
      Width = 280
      Height = 25
      Cursor = crHandPoint
      Align = alTop
      Alignment = taLeftJustify
      ParentBackground = False
      TabOrder = 4
      Visible = False
      OnClick = LeftPanelClick
    end
    object LinkPanel6: TPanel
      Tag = 5
      Left = 0
      Top = 125
      Width = 280
      Height = 25
      Cursor = crHandPoint
      Align = alTop
      Alignment = taLeftJustify
      ParentBackground = False
      TabOrder = 5
      Visible = False
      OnClick = LeftPanelClick
    end
    object LinkPanel7: TPanel
      Tag = 5
      Left = 0
      Top = 150
      Width = 280
      Height = 25
      Cursor = crHandPoint
      Align = alTop
      Alignment = taLeftJustify
      ParentBackground = False
      TabOrder = 6
      Visible = False
      OnClick = LeftPanelClick
    end
    object LinkPanel8: TPanel
      Tag = 5
      Left = 0
      Top = 175
      Width = 280
      Height = 25
      Cursor = crHandPoint
      Align = alTop
      Alignment = taLeftJustify
      ParentBackground = False
      TabOrder = 7
      Visible = False
      OnClick = LeftPanelClick
    end
    object LinkPanel9: TPanel
      Tag = 5
      Left = 0
      Top = 200
      Width = 280
      Height = 25
      Cursor = crHandPoint
      Align = alTop
      Alignment = taLeftJustify
      ParentBackground = False
      TabOrder = 8
      Visible = False
      OnClick = LeftPanelClick
    end
    object LinkPanel10: TPanel
      Tag = 5
      Left = 0
      Top = 225
      Width = 280
      Height = 25
      Cursor = crHandPoint
      Align = alTop
      Alignment = taLeftJustify
      ParentBackground = False
      TabOrder = 9
      Visible = False
      OnClick = LeftPanelClick
    end
  end
  object MainPanel: TPanel
    Left = 280
    Top = 0
    Width = 337
    Height = 474
    Align = alClient
    BevelOuter = bvNone
    TabOrder = 2
    inline FrameChat: TFrameChat
      Left = 0
      Top = 25
      Width = 337
      Height = 249
      Align = alClient
      TabOrder = 3
      ExplicitTop = 25
      ExplicitWidth = 337
      ExplicitHeight = 249
      inherited Panel1: TPanel
        Top = 217
        Width = 337
        ExplicitTop = 217
        ExplicitWidth = 337
        inherited edChatMsg: TEdit
          Width = 335
          ExplicitLeft = 1
          ExplicitTop = 1
          ExplicitWidth = 335
          ExplicitHeight = 30
        end
      end
      inherited Panel2: TPanel
        Width = 337
        Height = 217
        ExplicitLeft = 0
        ExplicitTop = 0
        ExplicitWidth = 337
        ExplicitHeight = 217
        inherited RichEdit1: TRichEdit
          Width = 335
          Height = 215
          ExplicitWidth = 335
          ExplicitHeight = 215
        end
      end
    end
    object Panel10: TPanel
      Tag = 5
      Left = 0
      Top = 0
      Width = 337
      Height = 25
      Align = alTop
      Caption = 'Location name'
      ParentBackground = False
      TabOrder = 0
      object bbChat: TSpeedButton
        Left = 248
        Top = 1
        Width = 88
        Height = 23
        Cursor = crHandPoint
        Align = alRight
        Caption = #1063#1072#1090
        Flat = True
        OnClick = bbChatClick
      end
    end
    object FramePanel: TPanel
      Left = 0
      Top = 274
      Width = 337
      Height = 200
      Align = alBottom
      TabOrder = 1
      inline FrameBank1: TFrameBank
        Left = 1
        Top = 1
        Width = 335
        Height = 198
        Align = alClient
        Font.Charset = RUSSIAN_CHARSET
        Font.Color = clWindowText
        Font.Height = -19
        Font.Name = 'Courier New'
        Font.Style = []
        ParentFont = False
        TabOrder = 0
        ExplicitLeft = 1
        ExplicitTop = 1
        ExplicitWidth = 335
        ExplicitHeight = 198
      end
      inline FrameDefault1: TFrameDefault
        Left = 1
        Top = 1
        Width = 335
        Height = 198
        Align = alClient
        TabOrder = 1
        ExplicitLeft = 1
        ExplicitTop = 1
        ExplicitWidth = 335
        ExplicitHeight = 198
      end
      inline FrameTavern1: TFrameTavern
        Left = 1
        Top = 1
        Width = 335
        Height = 198
        Align = alClient
        Font.Charset = RUSSIAN_CHARSET
        Font.Color = clWindowText
        Font.Height = -19
        Font.Name = 'Courier New'
        Font.Style = []
        ParentFont = False
        TabOrder = 2
        ExplicitLeft = 1
        ExplicitTop = 1
        ExplicitWidth = 335
        ExplicitHeight = 198
      end
      inline FrameOutlands1: TFrameOutlands
        Left = 1
        Top = 1
        Width = 335
        Height = 198
        Align = alClient
        TabOrder = 3
        ExplicitLeft = 1
        ExplicitTop = 1
        ExplicitWidth = 335
        ExplicitHeight = 198
      end
    end
    object Panel19: TPanel
      Left = 0
      Top = 25
      Width = 337
      Height = 249
      Align = alClient
      TabOrder = 2
      inline FrameShop1: TFrameShop
        Left = 1
        Top = 1
        Width = 335
        Height = 247
        Align = alClient
        Font.Charset = RUSSIAN_CHARSET
        Font.Color = clWindowText
        Font.Height = -19
        Font.Name = 'Courier New'
        Font.Style = []
        ParentFont = False
        TabOrder = 3
        ExplicitLeft = 1
        ExplicitTop = 1
        ExplicitWidth = 335
        ExplicitHeight = 247
        inherited Label1: TLabel
          Width = 335
          Height = 2
          ExplicitWidth = 335
          ExplicitHeight = 2
        end
        inherited Panel12: TPanel
          Width = 335
          ExplicitWidth = 335
          inherited Panel1: TPanel
            Width = 66
            ExplicitWidth = 66
          end
          inherited pnShopItemValueName: TPanel
            Left = 156
            ExplicitLeft = 156
          end
          inherited Panel3: TPanel
            Left = 67
            ExplicitLeft = 67
          end
          inherited Panel6: TPanel
            Left = 237
            ExplicitLeft = 237
          end
        end
        inherited Panel4: TPanel
          Width = 335
          ExplicitWidth = 335
          inherited pnItemSlot5Name: TPanel
            Width = 66
            ExplicitWidth = 66
          end
          inherited pnItemSlot5Value: TPanel
            Left = 156
            ExplicitLeft = 156
          end
          inherited pnItemSlot5Price: TPanel
            Left = 67
            ExplicitLeft = 67
          end
          inherited pnItemSlot5Level: TPanel
            Left = 237
            ExplicitLeft = 237
            ExplicitHeight = 33
          end
        end
        inherited Panel8: TPanel
          Width = 335
          ExplicitWidth = 335
          inherited pnItemSlot1Name: TPanel
            Width = 66
            ExplicitWidth = 66
          end
          inherited pnItemSlot1Value: TPanel
            Left = 156
            ExplicitLeft = 156
          end
          inherited pnItemSlot1Price: TPanel
            Left = 67
            ExplicitLeft = 67
          end
          inherited pnItemSlot1Level: TPanel
            Left = 237
            ExplicitLeft = 237
          end
        end
        inherited Panel2: TPanel
          Width = 335
          ExplicitWidth = 335
          inherited pnItemSlot4Name: TPanel
            Width = 66
            ExplicitWidth = 66
          end
          inherited pnItemSlot4Value: TPanel
            Left = 156
            ExplicitLeft = 156
          end
          inherited pnItemSlot4Price: TPanel
            Left = 67
            ExplicitLeft = 67
          end
          inherited pnItemSlot4Level: TPanel
            Left = 237
            ExplicitLeft = 237
            ExplicitHeight = 33
          end
        end
        inherited Panel16: TPanel
          Width = 335
          ExplicitWidth = 335
          inherited pnItemSlot3Name: TPanel
            Width = 66
            ExplicitWidth = 66
          end
          inherited pnItemSlot3Value: TPanel
            Left = 156
            ExplicitLeft = 156
          end
          inherited pnItemSlot3Price: TPanel
            Left = 67
            ExplicitLeft = 67
          end
          inherited pnItemSlot3Level: TPanel
            Left = 237
            ExplicitLeft = 237
            ExplicitHeight = 33
          end
        end
        inherited Panel20: TPanel
          Width = 335
          ExplicitWidth = 335
          inherited pnItemSlot2Name: TPanel
            Width = 66
            ExplicitWidth = 66
          end
          inherited pnItemSlot2Value: TPanel
            Left = 156
            ExplicitLeft = 156
          end
          inherited pnItemSlot2Price: TPanel
            Left = 67
            ExplicitLeft = 67
          end
          inherited pnItemSlot2Level: TPanel
            Left = 237
            ExplicitLeft = 237
            ExplicitHeight = 33
          end
        end
        inherited Panel5: TPanel
          Width = 335
          ExplicitWidth = 335
          inherited lbShopDescr: TLabel
            Width = 333
          end
        end
      end
      inline FrameInfo1: TFrameInfo
        Left = 1
        Top = 1
        Width = 335
        Height = 247
        Align = alClient
        TabOrder = 1
        ExplicitLeft = 1
        ExplicitTop = 1
        ExplicitWidth = 335
        ExplicitHeight = 247
        inherited StaticText2: TStaticText
          Top = 113
          Width = 335
          ExplicitTop = 113
          ExplicitWidth = 335
        end
        inherited StaticText1: TStaticText
          Width = 335
          Height = 113
          ExplicitWidth = 335
          ExplicitHeight = 113
        end
      end
      inline FrameLoot1: TFrameLoot
        Left = 1
        Top = 1
        Width = 335
        Height = 247
        Align = alClient
        TabOrder = 2
        ExplicitLeft = 1
        ExplicitTop = 1
        ExplicitWidth = 335
        ExplicitHeight = 247
      end
      inline FrameBattle1: TFrameBattle
        Left = 1
        Top = 1
        Width = 335
        Height = 247
        Align = alClient
        Font.Charset = RUSSIAN_CHARSET
        Font.Color = clWindowText
        Font.Height = -19
        Font.Name = 'Courier New'
        Font.Style = []
        ParentFont = False
        TabOrder = 0
        ExplicitLeft = 1
        ExplicitTop = 1
        ExplicitWidth = 335
        ExplicitHeight = 247
        inherited Panel1: TPanel
          Width = 335
          Height = 110
          ExplicitWidth = 335
          ExplicitHeight = 110
          inherited RichEdit1: TRichEdit
            Width = 333
            Height = 108
            BevelInner = bvNone
            BevelOuter = bvNone
            BorderStyle = bsNone
            Color = clBtnFace
            Font.Height = -15
            ParentFont = False
            PlainText = True
            ReadOnly = True
            ExplicitWidth = 333
            ExplicitHeight = 108
          end
        end
        inherited Panel2: TPanel
          Width = 335
          ExplicitWidth = 335
          inherited Panel3: TPanel
            Left = -3
            ExplicitLeft = -3
          end
        end
      end
    end
  end
end
